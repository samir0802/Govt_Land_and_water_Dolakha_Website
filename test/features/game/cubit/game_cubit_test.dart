import 'package:bloc_test/bloc_test.dart';
import 'package:block_puzzle/features/game/data/repositories/game_repository.dart';
import 'package:block_puzzle/features/game/domain/entities/block.dart';
import 'package:block_puzzle/features/game/presentation/cubit/game_cubit.dart';
import 'package:block_puzzle/features/game/presentation/cubit/game_state.dart';
import 'package:flutter/material.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:shared_preferences/shared_preferences.dart';

class TestGameCubit extends GameCubit {
  TestGameCubit({required super.repository});
  void seed(GameState state) => emit(state);
}

Future<GameRepository> repository() async {
  SharedPreferences.setMockInitialValues(<String, Object>{});
  return GameRepository(await SharedPreferences.getInstance());
}

void main() {
  const Block twoLine = Block(id: 'line', shape: <List<int>>[<int>[1, 1]], color: Colors.blue);

  blocTest<GameCubit, GameState>(
    'startGame emits loading then an in-progress game with three blocks',
    build: () async => GameCubit(repository: await repository()),
    act: (GameCubit cubit) => cubit.startGame(),
    expect: () => <Matcher>[isA<GameState>().having((GameState state) => state.status, 'status', GameStatus.loading), isA<GameState>().having((GameState state) => state.blocks.length, 'blocks', 3)],
  );

  test('validates out-of-bounds and occupied placement', () async {
    final TestGameCubit cubit = TestGameCubit(repository: await repository());
    cubit.seed(GameState.initial().copyWith(status: GameStatus.inProgress, blocks: const <Block>[twoLine]));
    expect(cubit.canPlace(twoLine, 0, 7), isFalse);
    expect(cubit.canPlace(twoLine, 0, 0), isTrue);
    await cubit.placeBlock(twoLine, 0, 0);
    expect(cubit.canPlace(twoLine, 0, 0), isFalse);
  });

  test('places a block and awards ten points per occupied cell', () async {
    final TestGameCubit cubit = TestGameCubit(repository: await repository());
    cubit.seed(GameState.initial().copyWith(status: GameStatus.inProgress, blocks: const <Block>[twoLine]));
    final bool placed = await cubit.placeBlock(twoLine, 0, 0);
    expect(placed, isTrue);
    expect(cubit.state.score, 20);
    expect(cubit.state.grid[0][0], Colors.blue);
    expect(cubit.state.grid[0][1], Colors.blue);
  });

  test('clears a completed row, shifts rows down, and adds row bonus', () async {
    final TestGameCubit cubit = TestGameCubit(repository: await repository());
    final List<List<Color?>> grid = List<List<Color?>>.generate(8, (_) => List<Color?>.filled(8, null));
    for (int column = 0; column < 6; column++) {
      grid[7][column] = Colors.red;
    }
    cubit.seed(GameState.initial().copyWith(status: GameStatus.inProgress, grid: grid, blocks: const <Block>[twoLine]));
    await cubit.placeBlock(twoLine, 7, 6);
    expect(cubit.state.score, 70);
    expect(cubit.state.grid[7].every((Color? color) => color == null), isTrue);
  });

  test('revive clears top rows and can only be used once', () async {
    final TestGameCubit cubit = TestGameCubit(repository: await repository());
    final List<List<Color?>> grid = List<List<Color?>>.generate(8, (_) => List<Color?>.filled(8, Colors.red));
    cubit.seed(GameState.initial().copyWith(status: GameStatus.gameOver, grid: grid));
    await cubit.reviveGame();
    expect(cubit.state.status, GameStatus.inProgress);
    expect(cubit.state.canRevive, isFalse);
    expect(cubit.state.grid[0].every((Color? color) => color == null), isTrue);
  });
}
