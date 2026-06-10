import 'dart:io';
import 'package:flutter/foundation.dart';
import 'package:purchases_flutter/purchases_flutter.dart';

import '../core/constants/app_constants.dart';
import '../features/shop/domain/entities/product.dart';

class PurchaseService {
  bool _configured = false;

  Future<void> initialize() async {
    if (kIsWeb || _configured) return;
    final String apiKey = Platform.isIOS ? AppConstants.iosRevenueCatKey : AppConstants.androidRevenueCatKey;
    if (apiKey.isEmpty) {
      debugPrint('RevenueCat API key is empty. Purchases run in offline fallback mode.');
      return;
    }
    await Purchases.configure(PurchasesConfiguration(apiKey));
    _configured = true;
  }

  Future<List<StoreProductInfo>> fetchProducts() async {
    await initialize();
    if (!_configured) return _fallbackProducts();
    final Offerings offerings = await Purchases.getOfferings();
    final Offering? current = offerings.current;
    if (current == null) return _fallbackProducts();
    return current.availablePackages.map((Package package) {
      final StoreProduct product = package.storeProduct;
      final bool consumable = product.identifier.contains('pack');
      return StoreProductInfo(
        id: product.identifier,
        title: product.title,
        description: product.description,
        price: product.priceString,
        kind: consumable ? ProductKind.consumable : ProductKind.nonConsumable,
      );
    }).toList();
  }

  Future<CustomerInfo?> purchase(String productId) async {
    await initialize();
    if (!_configured) return null;
    final Offerings offerings = await Purchases.getOfferings();
    final List<Package> packages = offerings.current?.availablePackages ?? <Package>[];
    Package? matchingPackage;
    for (final Package package in packages) {
      if (package.storeProduct.identifier == productId) {
        matchingPackage = package;
        break;
      }
    }
    if (matchingPackage == null) return null;
    return Purchases.purchasePackage(matchingPackage);
  }

  Future<CustomerInfo?> restore() async {
    await initialize();
    if (!_configured) return null;
    return Purchases.restorePurchases();
  }

  bool hasPremium(CustomerInfo? info) => info?.entitlements.active.containsKey(AppConstants.premiumEntitlement) ?? false;

  List<StoreProductInfo> _fallbackProducts() => const <StoreProductInfo>[
        StoreProductInfo(id: AppConstants.removeAdsProductId, title: 'Remove Ads', description: 'Permanently remove all advertising.', price: r'$4.99', kind: ProductKind.nonConsumable),
        StoreProductInfo(id: AppConstants.extraLifePackProductId, title: 'Extra Life Pack', description: 'Adds 3 extra lives.', price: r'$0.99', kind: ProductKind.consumable),
        StoreProductInfo(id: AppConstants.hintPackProductId, title: 'Hint Pack', description: 'Adds 10 hints.', price: r'$0.99', kind: ProductKind.consumable),
      ];
}
