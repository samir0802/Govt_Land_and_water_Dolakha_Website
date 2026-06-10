import 'package:equatable/equatable.dart';

enum ProductKind { nonConsumable, consumable }

class StoreProductInfo extends Equatable {
  const StoreProductInfo({required this.id, required this.title, required this.description, required this.price, required this.kind});

  final String id;
  final String title;
  final String description;
  final String price;
  final ProductKind kind;

  @override
  List<Object?> get props => <Object?>[id, title, description, price, kind];
}
