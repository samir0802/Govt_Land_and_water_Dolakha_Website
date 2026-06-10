import '../../../../core/constants/app_constants.dart';
import '../../../../services/purchase_service.dart';
import '../../domain/entities/product.dart';

class PurchaseRepository {
  PurchaseRepository(this._purchaseService);

  final PurchaseService _purchaseService;

  Future<List<StoreProductInfo>> loadProducts() => _purchaseService.fetchProducts();

  Future<PurchaseResult> purchaseProduct(String productId) async {
    final customerInfo = await _purchaseService.purchase(productId);
    return _resultFromProduct(productId, _purchaseService.hasPremium(customerInfo));
  }

  Future<PurchaseResult> restorePurchases() async {
    final customerInfo = await _purchaseService.restore();
    return PurchaseResult(isPremium: _purchaseService.hasPremium(customerInfo));
  }

  PurchaseResult _resultFromProduct(String productId, bool premium) {
    if (productId == AppConstants.extraLifePackProductId) return const PurchaseResult(extraLives: 3);
    if (productId == AppConstants.hintPackProductId) return const PurchaseResult(hints: 10);
    return PurchaseResult(isPremium: premium || productId == AppConstants.removeAdsProductId);
  }
}

class PurchaseResult {
  const PurchaseResult({this.isPremium = false, this.extraLives = 0, this.hints = 0});

  final bool isPremium;
  final int extraLives;
  final int hints;
}
