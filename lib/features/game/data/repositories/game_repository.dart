import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../../../../core/constants/app_constants.dart';

typedef GameGrid = List<List<Color?>>;

class GameRepository {
  GameRepository(this._preferences);

  final SharedPreferences _preferences;
  static const String _highScoreKey = 'high_score';
  static const String _gridKey = 'saved_grid';
  static const String _scoreKey = 'saved_score';

  Future<int> loadHighScore() async => _preferences.getInt(_highScoreKey) ?? 0;

  Future<void> saveHighScore(int score) async {
    final int current = await loadHighScore();
    if (score > current) {
      await _preferences.setInt(_highScoreKey, score);
    }
  }

  Future<void> resetHighScore() async => _preferences.setInt(_highScoreKey, 0);

  Future<void> saveGame({required GameGrid grid, required int score}) async {
    final List<List<int?>> serialized = grid
        .map((List<Color?> row) => row.map((Color? color) => color?.value).toList())
        .toList();
    await _preferences.setString(_gridKey, jsonEncode(serialized));
    await _preferences.setInt(_scoreKey, score);
  }

  Future<SavedGame?> loadGame() async {
    final String? rawGrid = _preferences.getString(_gridKey);
    final int? score = _preferences.getInt(_scoreKey);
    if (rawGrid == null || score == null) return null;
    final Object? decoded = jsonDecode(rawGrid);
    if (decoded is! List) return null;
    final GameGrid grid = decoded
        .map<List<Color?>>((Object? row) => (row as List<dynamic>)
            .map<Color?>((Object? value) => value == null ? null : Color(value as int))
            .toList())
        .toList();
    if (grid.length != AppConstants.gridRows || grid.any((List<Color?> row) => row.length != AppConstants.gridColumns)) {
      return null;
    }
    return SavedGame(grid: grid, score: score);
  }

  Future<void> clearSavedGame() async {
    await _preferences.remove(_gridKey);
    await _preferences.remove(_scoreKey);
  }
}

class SavedGame {
  const SavedGame({required this.grid, required this.score});

  final GameGrid grid;
  final int score;
}
