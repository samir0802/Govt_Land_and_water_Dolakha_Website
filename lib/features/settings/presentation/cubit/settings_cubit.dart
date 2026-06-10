import 'package:equatable/equatable.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../../../game/data/repositories/game_repository.dart';
import '../../data/repositories/settings_repository.dart';

class SettingsState extends Equatable {
  const SettingsState({
    required this.themeMode,
    required this.soundEnabled,
    required this.musicEnabled,
    required this.highScore,
    required this.extraLives,
    required this.hints,
    required this.isPremium,
  });

  final ThemeMode themeMode;
  final bool soundEnabled;
  final bool musicEnabled;
  final int highScore;
  final int extraLives;
  final int hints;
  final bool isPremium;

  SettingsState copyWith({
    ThemeMode? themeMode,
    bool? soundEnabled,
    bool? musicEnabled,
    int? highScore,
    int? extraLives,
    int? hints,
    bool? isPremium,
  }) =>
      SettingsState(
        themeMode: themeMode ?? this.themeMode,
        soundEnabled: soundEnabled ?? this.soundEnabled,
        musicEnabled: musicEnabled ?? this.musicEnabled,
        highScore: highScore ?? this.highScore,
        extraLives: extraLives ?? this.extraLives,
        hints: hints ?? this.hints,
        isPremium: isPremium ?? this.isPremium,
      );

  @override
  List<Object?> get props => <Object?>[themeMode, soundEnabled, musicEnabled, highScore, extraLives, hints, isPremium];
}

class SettingsCubit extends Cubit<SettingsState> {
  SettingsCubit({required SettingsRepository settingsRepository, required GameRepository gameRepository})
      : _settingsRepository = settingsRepository,
        _gameRepository = gameRepository,
        super(SettingsState(
          themeMode: settingsRepository.loadThemeMode(),
          soundEnabled: settingsRepository.loadSoundEnabled(),
          musicEnabled: settingsRepository.loadMusicEnabled(),
          highScore: 0,
          extraLives: settingsRepository.loadExtraLives(),
          hints: settingsRepository.loadHints(),
          isPremium: settingsRepository.loadPremium(),
        ));

  final SettingsRepository _settingsRepository;
  final GameRepository _gameRepository;

  Future<void> load() async => emit(state.copyWith(highScore: await _gameRepository.loadHighScore()));

  Future<void> setThemeMode(ThemeMode mode) async {
    await _settingsRepository.saveThemeMode(mode);
    emit(state.copyWith(themeMode: mode));
  }

  Future<void> toggleSound(bool enabled) async {
    await _settingsRepository.saveSoundEnabled(enabled);
    emit(state.copyWith(soundEnabled: enabled));
  }

  Future<void> toggleMusic(bool enabled) async {
    await _settingsRepository.saveMusicEnabled(enabled);
    emit(state.copyWith(musicEnabled: enabled));
  }

  Future<void> resetHighScore() async {
    await _gameRepository.resetHighScore();
    emit(state.copyWith(highScore: 0));
  }

  Future<void> grantPremium() async {
    await _settingsRepository.savePremium(true);
    emit(state.copyWith(isPremium: true));
  }

  Future<void> addExtraLives(int amount) async {
    final int next = state.extraLives + amount;
    await _settingsRepository.saveExtraLives(next);
    emit(state.copyWith(extraLives: next));
  }

  Future<void> addHints(int amount) async {
    final int next = state.hints + amount;
    await _settingsRepository.saveHints(next);
    emit(state.copyWith(hints: next));
  }
}
