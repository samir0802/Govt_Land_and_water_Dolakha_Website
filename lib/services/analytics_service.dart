import 'package:firebase_analytics/firebase_analytics.dart';
import 'package:flutter/foundation.dart';

class AnalyticsService {
  FirebaseAnalytics? get _analytics => kIsWeb ? null : FirebaseAnalytics.instance;

  Future<void> logGameStart() async => _analytics?.logEvent(name: 'game_start');
  Future<void> logBlockPlaced(int score) async => _analytics?.logEvent(name: 'block_placed', parameters: <String, Object>{'score': score});
  Future<void> logPurchase(String productId) async => _analytics?.logEvent(name: 'purchase_started', parameters: <String, Object>{'product_id': productId});
}
