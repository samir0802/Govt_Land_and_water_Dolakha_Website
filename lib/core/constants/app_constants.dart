import 'package:flutter/material.dart';

class AppConstants {
  static const int gridRows = 8;
  static const int gridColumns = 8;
  static const int pointsPerCell = 10;
  static const int pointsPerClearedRow = 50;
  static const int fourRowClearBonus = 100;
  static const Duration scoreMultiplierDuration = Duration(seconds: 60);
  static const String appName = 'Block Puzzle';
  static const String premiumEntitlement = 'premium';
  static const String removeAdsProductId = 'remove_ads';
  static const String extraLifePackProductId = 'extra_life_pack';
  static const String hintPackProductId = 'hint_pack';
  static const String androidRevenueCatKey = String.fromEnvironment('REVENUECAT_ANDROID_KEY');
  static const String iosRevenueCatKey = String.fromEnvironment('REVENUECAT_IOS_KEY');
  static const Color emptyCellColor = Color(0xFF1F2937);
}
