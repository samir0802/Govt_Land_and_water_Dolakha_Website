import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';

class SettingsRepository {
  SettingsRepository(this._preferences);

  final SharedPreferences _preferences;
  static const String _themeKey = 'theme_mode';
  static const String _soundKey = 'sound_enabled';
  static const String _musicKey = 'music_enabled';
  static const String _extraLivesKey = 'extra_lives';
  static const String _hintsKey = 'hints';
  static const String _premiumKey = 'premium';

  ThemeMode loadThemeMode() {
    final String value = _preferences.getString(_themeKey) ?? ThemeMode.system.name;
    return ThemeMode.values.firstWhere((ThemeMode mode) => mode.name == value, orElse: () => ThemeMode.system);
  }

  Future<void> saveThemeMode(ThemeMode mode) async => _preferences.setString(_themeKey, mode.name);
  bool loadSoundEnabled() => _preferences.getBool(_soundKey) ?? true;
  Future<void> saveSoundEnabled(bool enabled) async => _preferences.setBool(_soundKey, enabled);
  bool loadMusicEnabled() => _preferences.getBool(_musicKey) ?? true;
  Future<void> saveMusicEnabled(bool enabled) async => _preferences.setBool(_musicKey, enabled);
  int loadExtraLives() => _preferences.getInt(_extraLivesKey) ?? 0;
  Future<void> saveExtraLives(int value) async => _preferences.setInt(_extraLivesKey, value);
  int loadHints() => _preferences.getInt(_hintsKey) ?? 0;
  Future<void> saveHints(int value) async => _preferences.setInt(_hintsKey, value);
  bool loadPremium() => _preferences.getBool(_premiumKey) ?? false;
  Future<void> savePremium(bool value) async => _preferences.setBool(_premiumKey, value);
}
