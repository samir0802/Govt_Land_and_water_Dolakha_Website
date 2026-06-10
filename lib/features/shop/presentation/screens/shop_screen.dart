import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../../../settings/presentation/cubit/settings_cubit.dart';
import '../../data/repositories/purchase_repository.dart';
import '../cubit/shop_cubit.dart';
import '../cubit/shop_state.dart';
import '../../../../shared/widgets/shimmer_loader.dart';

class ShopScreen extends StatefulWidget {
  const ShopScreen({super.key});
  static const String routeName = '/shop';

  @override
  State<ShopScreen> createState() => _ShopScreenState();
}

class _ShopScreenState extends State<ShopScreen> {
  @override
  void initState() {
    super.initState();
    context.read<ShopCubit>().loadProducts();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Shop')),
      body: BlocConsumer<ShopCubit, ShopState>(
        listener: (BuildContext context, ShopState state) {
          if (state.message != null) ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(state.message ?? '')));
        },
        builder: (BuildContext context, ShopState state) {
          if (state.status == ShopStatus.loading) return const Column(children: <Widget>[ShimmerLoader(), ShimmerLoader(), ShimmerLoader()]);
          return ListView(
            padding: const EdgeInsets.all(16),
            children: <Widget>[
              ...state.products.map((product) => Card(
                    child: ListTile(
                      title: Text(product.title),
                      subtitle: Text(product.description),
                      trailing: FilledButton(
                        onPressed: () async {
                          final PurchaseResult? result = await context.read<ShopCubit>().purchaseProduct(product.id);
                          if (!context.mounted || result == null) return;
                          final SettingsCubit settings = context.read<SettingsCubit>();
                          if (result.isPremium) await settings.grantPremium();
                          if (result.extraLives > 0) await settings.addExtraLives(result.extraLives);
                          if (result.hints > 0) await settings.addHints(result.hints);
                        },
                        child: Text(product.price),
                      ),
                    ),
                  )),
              const SizedBox(height: 16),
              OutlinedButton.icon(
                onPressed: () async {
                  final PurchaseResult? result = await context.read<ShopCubit>().restorePurchases();
                  if (context.mounted && result?.isPremium == true) await context.read<SettingsCubit>().grantPremium();
                },
                icon: const Icon(Icons.restore),
                label: const Text('Restore Purchases'),
              ),
            ],
          );
        },
      ),
    );
  }
}
