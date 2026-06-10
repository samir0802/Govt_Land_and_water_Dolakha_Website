import 'dart:math';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../../../../core/constants/app_constants.dart';
import '../../../../core/utils/color_utils.dart';
import '../../data/repositories/game_repository.dart';
import '../../domain/entities/block.dart';
import '../../domain/entities/block_catalog.dart';
import 'game_state.dart';

class GameCubit extends Cubit<GameState> {
  GameCubit({required GameRepository repository, Random? random})
      : _repository = repository,
        _random = random ?? Random(),
        super(GameState.initial());

  final GameRepository _repository;
  final Random _random;

  Future<void> startGame() async {
    emit(state.copyWith(status: GameStatus.loading, clearError: true, clearHint: true));
    final int highScore = await _repository.loadHighScore();
    emit(GameState(
      status: GameStatus.inProgress,
      grid: _emptyGrid(),
      blocks: _generateTray(),
      score: 0,
      highScore: highScore,
      canRevive: true,
    ));
  }

  bool canPlace(Block block, int row, int column, {List<List<Color?>>? grid}) {
    final List<List<Color?>> targetGrid = grid ?? state.grid;
    for (final Point cell in block.occupiedCells()) {
      final int gridRow = row + cell.row;
      final int gridColumn = column + cell.column;
      if (gridRow < 0 || gridRow >= AppConstants.gridRows || gridColumn < 0 || gridColumn >= AppConstants.gridColumns) {
        return false;
      }
      if (targetGrid[gridRow][gridColumn] != null) {
        return false;
      }
    }
    return true;
  }

  Future<bool> placeBlock(Block block, int row, int column) async {
    if (state.status != GameStatus.inProgress) return false;
    if (!state.blocks.contains(block)) {
      emit(state.copyWith(errorMessage: 'That block is not available.'));
      return false;
    }
    if (!canPlace(block, row, column)) {
      emit(state.copyWith(errorMessage: 'Block cannot be placed there.'));
      return false;
    }

    final List<List<Color?>> mergedGrid = _cloneGrid(state.grid);
    for (final Point cell in block.occupiedCells()) {
      mergedGrid[row + cell.row][column + cell.column] = block.color;
    }

    final _ClearResult clearResult = _clearCompletedRows(mergedGrid);
    final int placementScore = block.cellCount * AppConstants.pointsPerCell;
    final int rowBonus = clearResult.clearedRows * AppConstants.pointsPerClearedRow;
    final int megaBonus = clearResult.clearedRows >= 4 ? AppConstants.fourRowClearBonus : 0;
    final int multiplier = state.isMultiplierActive ? 2 : 1;
    final int nextScore = state.score + ((placementScore + rowBonus + megaBonus) * multiplier);
    final int nextHighScore = max(state.highScore, nextScore);
    final List<Block> nextBlocks = List<Block>.from(state.blocks)
      ..remove(block)
      ..add(_randomBlock());
    final bool isGameOver = !_hasAnyValidPlacement(clearResult.grid, nextBlocks);

    await _repository.saveGame(grid: clearResult.grid, score: nextScore);
    await _repository.saveHighScore(nextHighScore);

    emit(state.copyWith(
      status: isGameOver ? GameStatus.gameOver : GameStatus.inProgress,
      grid: clearResult.grid,
      blocks: nextBlocks,
      score: nextScore,
      highScore: nextHighScore,
      clearHint: true,
      clearError: true,
    ));
    return true;
  }

  Point? findHint() {
    for (final Block block in state.blocks) {
      for (int row = 0; row < AppConstants.gridRows; row++) {
        for (int column = 0; column < AppConstants.gridColumns; column++) {
          if (canPlace(block, row, column)) {
            final Point hint = Point(row, column);
            emit(state.copyWith(hintPosition: hint, clearError: true));
            return hint;
          }
        }
      }
    }
    emit(state.copyWith(errorMessage: 'No valid placement is available.'));
    return null;
  }

  void activateScoreMultiplier() {
    emit(state.copyWith(multiplierExpiresAt: DateTime.now().add(AppConstants.scoreMultiplierDuration)));
  }

  Future<void> reviveGame() async {
    if (!state.canRevive || state.status != GameStatus.gameOver) {
      emit(state.copyWith(errorMessage: 'No revives are available.'));
      return;
    }
    final List<List<Color?>> revivedGrid = _cloneGrid(state.grid);
    for (int row = 0; row < 2; row++) {
      for (int column = 0; column < AppConstants.gridColumns; column++) {
        revivedGrid[row][column] = null;
      }
    }
    emit(state.copyWith(status: GameStatus.inProgress, grid: revivedGrid, canRevive: false, clearError: true));
    await _repository.saveGame(grid: revivedGrid, score: state.score);
  }

  Future<void> loadSavedGame() async {
    emit(state.copyWith(status: GameStatus.loading));
    final SavedGame? savedGame = await _repository.loadGame();
    final int highScore = await _repository.loadHighScore();
    if (savedGame == null) {
      await startGame();
      return;
    }
    final List<Block> tray = _generateTray();
    emit(GameState(
      status: _hasAnyValidPlacement(savedGame.grid, tray) ? GameStatus.inProgress : GameStatus.gameOver,
      grid: savedGame.grid,
      blocks: tray,
      score: savedGame.score,
      highScore: highScore,
      canRevive: true,
    ));
  }

  List<Block> _generateTray() => List<Block>.generate(3, (_) => _randomBlock());

  Block _randomBlock() {
    final List<Block> blocks = BlockCatalog.all(color: ColorUtils.randomBlockColor(_random));
    return blocks[_random.nextInt(blocks.length)];
  }

  bool _hasAnyValidPlacement(List<List<Color?>> grid, List<Block> blocks) {
    for (final Block block in blocks) {
      for (int row = 0; row < AppConstants.gridRows; row++) {
        for (int column = 0; column < AppConstants.gridColumns; column++) {
          if (canPlace(block, row, column, grid: grid)) return true;
        }
      }
    }
    return false;
  }

  _ClearResult _clearCompletedRows(List<List<Color?>> grid) {
    final List<List<Color?>> remainingRows = grid.where((List<Color?> row) => row.any((Color? cell) => cell == null)).toList();
    final int clearedRows = AppConstants.gridRows - remainingRows.length;
    final List<List<Color?>> clearedGrid = <List<Color?>>[
      ...List<List<Color?>>.generate(clearedRows, (_) => List<Color?>.filled(AppConstants.gridColumns, null)),
      ...remainingRows,
    ];
    return _ClearResult(grid: clearedGrid, clearedRows: clearedRows);
  }

  static List<List<Color?>> _emptyGrid() => List<List<Color?>>.generate(
        AppConstants.gridRows,
        (_) => List<Color?>.filled(AppConstants.gridColumns, null),
      );

  static List<List<Color?>> _cloneGrid(List<List<Color?>> grid) => grid.map((List<Color?> row) => List<Color?>.from(row)).toList();
}

class _ClearResult {
  const _ClearResult({required this.grid, required this.clearedRows});

  final List<List<Color?>> grid;
  final int clearedRows;
}
