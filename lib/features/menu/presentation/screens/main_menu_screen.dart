import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:google_mobile_ads/google_mobile_ads.dart';

import '../../../../services/ad_service.dart';
import '../../../settings/presentation/cubit/settings_cubit.dart';
import '../../../../shared/widgets/primary_button.dart';

class MainMenuScreen extends StatefulWidget {
  const MainMenuScreen({super.key});
  static const String routeName = '/';

  @override
  State<MainMenuScreen> createState() => _MainMenuScreenState();
}

class _MainMenuScreenState extends State<MainMenuScreen> {
  BannerAd? _bannerAd;
  bool _bannerReady = false;

  @override
  void initState() {
    super.initState();
    context.read<SettingsCubit>().load();
    final bool premium = context.read<SettingsCubit>().state.isPremium;
    if (!premium) {
      _bannerAd = context.read<AdService>().createBannerAd(
            onLoaded: () => mounted ? setState(() => _bannerReady = true) : null,
            onFailed: (_) => mounted ? setState(() => _bannerReady = false) : null,
          );
    }
  }

  @override
  void dispose() {
    _bannerAd?.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: BlocBuilder<SettingsCubit, SettingsState>(
          builder: (BuildContext context, SettingsState state) {
            return Column(
              children: <Widget>[
                const Spacer(),
                Icon(Icons.extension, size: 96, color: Theme.of(context).colorScheme.primary),
                Text('Block Puzzle', style: Theme.of(context).textTheme.headlineLarge, textAlign: TextAlign.center),
                const SizedBox(height: 12),
                Text('High Score: ${state.highScore}', style: Theme.of(context).textTheme.titleLarge),
                const SizedBox(height: 32),
                PrimaryButton(label: 'Play', icon: Icons.play_arrow, onPressed: () => Navigator.of(context).pushNamed('/game')),
                const SizedBox(height: 12),
                PrimaryButton(label: 'Shop', icon: Icons.store, onPressed: () => Navigator.of(context).pushNamed('/shop')),
                const SizedBox(height: 12),
                PrimaryButton(label: 'Settings', icon: Icons.settings, onPressed: () => Navigator.of(context).pushNamed('/settings')),
                const Spacer(),
                if (_bannerReady && _bannerAd != null && !state.isPremium)
                  Builder(builder: (BuildContext context) {
                    final BannerAd banner = _bannerAd as BannerAd;
                    return SizedBox(width: banner.size.width.toDouble(), height: banner.size.height.toDouble(), child: AdWidget(ad: banner));
                  }),
              ],
            );
          },
        ),
      ),
    );
  }
}
