import 'package:firebase_core/firebase_core.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import 'core/di/injection_container.dart';
import 'core/themes/app_theme.dart';
import 'features/ads/presentation/cubit/ad_cubit.dart';
import 'features/game/data/repositories/game_repository.dart';
import 'features/game/presentation/cubit/game_cubit.dart';
import 'features/game/presentation/screens/game_screen.dart';
import 'features/menu/presentation/screens/main_menu_screen.dart';
import 'features/settings/data/repositories/settings_repository.dart';
import 'features/settings/presentation/cubit/settings_cubit.dart';
import 'features/settings/presentation/screens/settings_screen.dart';
import 'features/shop/data/repositories/purchase_repository.dart';
import 'features/shop/presentation/cubit/shop_cubit.dart';
import 'features/shop/presentation/screens/shop_screen.dart';
import 'services/ad_service.dart';

Future<void> main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await Firebase.initializeApp();
  await configureDependencies();
  await sl<AdService>().initialize();
  runApp(const BlockPuzzleApp());
}

class BlockPuzzleApp extends StatelessWidget {
  const BlockPuzzleApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MultiRepositoryProvider(
      providers: [
        RepositoryProvider<AdService>.value(value: sl<AdService>()),
      ],
      child: MultiBlocProvider(
        providers: [
          BlocProvider<SettingsCubit>(create: (_) => SettingsCubit(settingsRepository: sl<SettingsRepository>(), gameRepository: sl<GameRepository>())..load()),
          BlocProvider<GameCubit>(create: (_) => GameCubit(repository: sl<GameRepository>())),
          BlocProvider<ShopCubit>(create: (_) => ShopCubit(purchaseRepository: sl<PurchaseRepository>())),
          BlocProvider<AdCubit>(create: (_) => AdCubit(sl<AdService>())),
        ],
        child: BlocBuilder<SettingsCubit, SettingsState>(
          builder: (BuildContext context, SettingsState state) {
            return MaterialApp(
              title: 'Block Puzzle',
              debugShowCheckedModeBanner: false,
              theme: AppTheme.light(),
              darkTheme: AppTheme.dark(),
              themeMode: state.themeMode,
              routes: <String, WidgetBuilder>{
                MainMenuScreen.routeName: (_) => const MainMenuScreen(),
                GameScreen.routeName: (_) => const GameScreen(),
                ShopScreen.routeName: (_) => const ShopScreen(),
                SettingsScreen.routeName: (_) => const SettingsScreen(),
              },
            );
          },
        ),
      ),
    );
  }
}
