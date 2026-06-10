import 'package:get_it/get_it.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../../features/game/data/repositories/game_repository.dart';
import '../../features/settings/data/repositories/settings_repository.dart';
import '../../features/shop/data/repositories/purchase_repository.dart';
import '../../services/ad_service.dart';
import '../../services/analytics_service.dart';
import '../../services/purchase_service.dart';

final GetIt sl = GetIt.instance;

Future<void> configureDependencies() async {
  final SharedPreferences preferences = await SharedPreferences.getInstance();
  sl.registerSingleton<SharedPreferences>(preferences);
  sl.registerLazySingleton<GameRepository>(() => GameRepository(sl<SharedPreferences>()));
  sl.registerLazySingleton<SettingsRepository>(() => SettingsRepository(sl<SharedPreferences>()));
  sl.registerLazySingleton<PurchaseService>(PurchaseService.new);
  sl.registerLazySingleton<PurchaseRepository>(() => PurchaseRepository(sl<PurchaseService>()));
  sl.registerLazySingleton<AdService>(AdService.new);
  sl.registerLazySingleton<AnalyticsService>(AnalyticsService.new);
}
