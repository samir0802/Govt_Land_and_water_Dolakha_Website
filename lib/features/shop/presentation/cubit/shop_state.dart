import 'package:equatable/equatable.dart';

import '../../domain/entities/product.dart';

enum ShopStatus { initial, loading, productsLoaded, purchaseSuccess, purchaseFailure }

class ShopState extends Equatable {
  const ShopState({required this.status, required this.products, this.message});

  factory ShopState.initial() => const ShopState(status: ShopStatus.initial, products: <StoreProductInfo>[]);

  final ShopStatus status;
  final List<StoreProductInfo> products;
  final String? message;

  ShopState copyWith({ShopStatus? status, List<StoreProductInfo>? products, String? message}) => ShopState(
        status: status ?? this.status,
        products: products ?? this.products,
        message: message,
      );

  @override
  List<Object?> get props => <Object?>[status, products, message];
}
