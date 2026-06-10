import 'package:flutter_bloc/flutter_bloc.dart';

import '../../data/repositories/purchase_repository.dart';
import 'shop_state.dart';

class ShopCubit extends Cubit<ShopState> {
  ShopCubit({required PurchaseRepository purchaseRepository})
      : _purchaseRepository = purchaseRepository,
        super(ShopState.initial());

  final PurchaseRepository _purchaseRepository;

  Future<void> loadProducts() async {
    try {
      emit(state.copyWith(status: ShopStatus.loading));
      final products = await _purchaseRepository.loadProducts();
      emit(ShopState(status: ShopStatus.productsLoaded, products: products));
    } catch (error) {
      emit(state.copyWith(status: ShopStatus.purchaseFailure, message: 'Products could not be loaded: $error'));
    }
  }

  Future<PurchaseResult?> purchaseProduct(String productId) async {
    try {
      emit(state.copyWith(status: ShopStatus.loading));
      final PurchaseResult result = await _purchaseRepository.purchaseProduct(productId);
      emit(state.copyWith(status: ShopStatus.purchaseSuccess, message: 'Purchase successful.'));
      return result;
    } catch (error) {
      emit(state.copyWith(status: ShopStatus.purchaseFailure, message: 'Purchase failed: $error'));
      return null;
    }
  }

  Future<PurchaseResult?> restorePurchases() async {
    try {
      emit(state.copyWith(status: ShopStatus.loading));
      final PurchaseResult result = await _purchaseRepository.restorePurchases();
      emit(state.copyWith(status: ShopStatus.purchaseSuccess, message: 'Purchases restored.'));
      return result;
    } catch (error) {
      emit(state.copyWith(status: ShopStatus.purchaseFailure, message: 'Restore failed: $error'));
      return null;
    }
  }
}
