import 'package:equatable/equatable.dart';
import 'package:flutter/material.dart';

import '../../domain/entities/block.dart';

enum GameStatus { initial, loading, inProgress, gameOver }

class GameState extends Equatable {
  const GameState({
    required this.status,
    required this.grid,
    required this.blocks,
    required this.score,
    required this.highScore,
    required this.canRevive,
    this.hintPosition,
    this.errorMessage,
    this.multiplierExpiresAt,
  });

  factory GameState.initial() => GameState(
        status: GameStatus.initial,
        grid: List<List<Color?>>.generate(8, (_) => List<Color?>.filled(8, null)),
        blocks: const <Block>[],
        score: 0,
        highScore: 0,
        canRevive: true,
      );

  final GameStatus status;
  final List<List<Color?>> grid;
  final List<Block> blocks;
  final int score;
  final int highScore;
  final bool canRevive;
  final Point? hintPosition;
  final String? errorMessage;
  final DateTime? multiplierExpiresAt;

  bool get isMultiplierActive {
    final DateTime? expiresAt = multiplierExpiresAt;
    return expiresAt != null && DateTime.now().isBefore(expiresAt);
  }

  GameState copyWith({
    GameStatus? status,
    List<List<Color?>>? grid,
    List<Block>? blocks,
    int? score,
    int? highScore,
    bool? canRevive,
    Point? hintPosition,
    bool clearHint = false,
    String? errorMessage,
    bool clearError = false,
    DateTime? multiplierExpiresAt,
  }) {
    return GameState(
      status: status ?? this.status,
      grid: grid ?? this.grid,
      blocks: blocks ?? this.blocks,
      score: score ?? this.score,
      highScore: highScore ?? this.highScore,
      canRevive: canRevive ?? this.canRevive,
      hintPosition: clearHint ? null : hintPosition ?? this.hintPosition,
      errorMessage: clearError ? null : errorMessage ?? this.errorMessage,
      multiplierExpiresAt: multiplierExpiresAt ?? this.multiplierExpiresAt,
    );
  }

  @override
  List<Object?> get props => <Object?>[status, grid, blocks, score, highScore, canRevive, hintPosition, errorMessage, multiplierExpiresAt];
}
