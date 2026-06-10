import 'package:equatable/equatable.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../../../../services/ad_service.dart';

enum AdStatus { initial, loading, ready, failed, rewarded }
enum AdRewardType { extraLife, hint, scoreMultiplier }

class AdState extends Equatable {
  const AdState({required this.status, this.rewardType, this.message});
  factory AdState.initial() => const AdState(status: AdStatus.initial);

  final AdStatus status;
  final AdRewardType? rewardType;
  final String? message;

  AdState copyWith({AdStatus? status, AdRewardType? rewardType, String? message}) => AdState(
        status: status ?? this.status,
        rewardType: rewardType ?? this.rewardType,
        message: message,
      );

  @override
  List<Object?> get props => <Object?>[status, rewardType, message];
}

class AdCubit extends Cubit<AdState> {
  AdCubit(this._adService) : super(AdState.initial());

  final AdService _adService;

  Future<void> loadRewardedAd() async {
    emit(state.copyWith(status: AdStatus.loading));
    await _adService.loadRewardedAd(
      onLoaded: () => emit(state.copyWith(status: AdStatus.ready)),
      onFailed: (String message) => emit(state.copyWith(status: AdStatus.failed, message: message)),
    );
  }

  Future<void> showRewardedAd(AdRewardType type) async {
    final bool shown = await _adService.showRewardedAd(onRewarded: () => emit(AdState(status: AdStatus.rewarded, rewardType: type)));
    if (!shown) emit(state.copyWith(status: AdStatus.failed, message: 'Rewarded ad is not ready.'));
  }

  Future<void> loadInterstitialAd() async {
    emit(state.copyWith(status: AdStatus.loading));
    await _adService.loadInterstitialAd(
      onLoaded: () => emit(state.copyWith(status: AdStatus.ready)),
      onFailed: (String message) => emit(state.copyWith(status: AdStatus.failed, message: message)),
    );
  }

  Future<void> showInterstitialAd() async {
    final bool shown = await _adService.showInterstitialAd();
    if (!shown) emit(state.copyWith(status: AdStatus.failed, message: 'Interstitial ad is not ready.'));
  }
}
