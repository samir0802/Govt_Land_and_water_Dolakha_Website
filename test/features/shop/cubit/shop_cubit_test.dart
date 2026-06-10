import 'package:bloc_test/bloc_test.dart';
import 'package:block_puzzle/features/shop/data/repositories/purchase_repository.dart';
import 'package:block_puzzle/features/shop/domain/entities/product.dart';
import 'package:block_puzzle/features/shop/presentation/cubit/shop_cubit.dart';
import 'package:block_puzzle/features/shop/presentation/cubit/shop_state.dart';
import 'package:flutter_test/flutter_test.dart';

class FakePurchaseRepository implements PurchaseRepository {
  @override
  Future<List<StoreProductInfo>> loadProducts() async => const <StoreProductInfo>[
        StoreProductInfo(id: 'remove_ads', title: 'Remove Ads', description: 'No ads', price: r'$4.99', kind: ProductKind.nonConsumable),
      ];

  @override
  Future<PurchaseResult> purchaseProduct(String productId) async => const PurchaseResult(isPremium: true);

  @override
  Future<PurchaseResult> restorePurchases() async => const PurchaseResult(isPremium: true);
}

void main() {
  blocTest<ShopCubit, ShopState>(
    'loads products',
    build: () => ShopCubit(purchaseRepository: FakePurchaseRepository()),
    act: (ShopCubit cubit) => cubit.loadProducts(),
    expect: () => <Matcher>[isA<ShopState>().having((ShopState state) => state.status, 'status', ShopStatus.loading), isA<ShopState>().having((ShopState state) => state.products.length, 'products', 1)],
  );

  test('purchase returns premium result', () async {
    final ShopCubit cubit = ShopCubit(purchaseRepository: FakePurchaseRepository());
    final PurchaseResult? result = await cubit.purchaseProduct('remove_ads');
    expect(result?.isPremium, isTrue);
    expect(cubit.state.status, ShopStatus.purchaseSuccess);
  });
}
