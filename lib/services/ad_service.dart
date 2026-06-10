import 'package:flutter/foundation.dart';
import 'package:google_mobile_ads/google_mobile_ads.dart';

class AdService {
  static const String bannerAdUnitId = 'ca-app-pub-3940256099942544/6300978111';
  static const String interstitialAdUnitId = 'ca-app-pub-3940256099942544/1033173712';
  static const String rewardedAdUnitId = 'ca-app-pub-3940256099942544/5224354917';

  RewardedAd? _rewardedAd;
  InterstitialAd? _interstitialAd;

  Future<void> initialize() async {
    if (kIsWeb) return;
    await MobileAds.instance.initialize();
  }

  BannerAd createBannerAd({required VoidCallback onLoaded, required ValueChanged<String> onFailed}) {
    return BannerAd(
      adUnitId: bannerAdUnitId,
      request: const AdRequest(),
      size: AdSize.banner,
      listener: BannerAdListener(
        onAdLoaded: (_) => onLoaded(),
        onAdFailedToLoad: (Ad ad, LoadAdError error) {
          ad.dispose();
          onFailed(error.message);
        },
      ),
    )..load();
  }

  Future<void> loadRewardedAd({required VoidCallback onLoaded, required ValueChanged<String> onFailed}) async {
    await RewardedAd.load(
      adUnitId: rewardedAdUnitId,
      request: const AdRequest(),
      rewardedAdLoadCallback: RewardedAdLoadCallback(
        onAdLoaded: (RewardedAd ad) {
          _rewardedAd = ad;
          onLoaded();
        },
        onAdFailedToLoad: (LoadAdError error) => onFailed(error.message),
      ),
    );
  }

  Future<bool> showRewardedAd({required VoidCallback onRewarded}) async {
    final RewardedAd? ad = _rewardedAd;
    if (ad == null) return false;
    _rewardedAd = null;
    bool earnedReward = false;
    ad.fullScreenContentCallback = FullScreenContentCallback<RewardedAd>(onAdDismissedFullScreenContent: (RewardedAd dismissedAd) {
      dismissedAd.dispose();
    }, onAdFailedToShowFullScreenContent: (RewardedAd failedAd, AdError error) {
      failedAd.dispose();
    });
    await ad.show(onUserEarnedReward: (_, __) {
      earnedReward = true;
      onRewarded();
    });
    return earnedReward;
  }

  Future<void> loadInterstitialAd({required VoidCallback onLoaded, required ValueChanged<String> onFailed}) async {
    await InterstitialAd.load(
      adUnitId: interstitialAdUnitId,
      request: const AdRequest(),
      adLoadCallback: InterstitialAdLoadCallback(
        onAdLoaded: (InterstitialAd ad) {
          _interstitialAd = ad;
          onLoaded();
        },
        onAdFailedToLoad: (LoadAdError error) => onFailed(error.message),
      ),
    );
  }

  Future<bool> showInterstitialAd() async {
    final InterstitialAd? ad = _interstitialAd;
    if (ad == null) return false;
    _interstitialAd = null;
    ad.fullScreenContentCallback = FullScreenContentCallback<InterstitialAd>(onAdDismissedFullScreenContent: (InterstitialAd dismissedAd) {
      dismissedAd.dispose();
    }, onAdFailedToShowFullScreenContent: (InterstitialAd failedAd, AdError error) {
      failedAd.dispose();
    });
    await ad.show();
    return true;
  }

  void dispose() {
    _rewardedAd?.dispose();
    _interstitialAd?.dispose();
  }
}
