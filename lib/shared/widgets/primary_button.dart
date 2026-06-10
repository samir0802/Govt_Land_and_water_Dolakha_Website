import 'package:flutter/material.dart';

class PrimaryButton extends StatelessWidget {
  const PrimaryButton({super.key, required this.label, required this.onPressed, this.icon});

  final String label;
  final VoidCallback? onPressed;
  final IconData? icon;

  @override
  Widget build(BuildContext context) {
    final Widget text = Text(label);
    if (icon == null) {
      return FilledButton(onPressed: onPressed, child: text);
    }
    return FilledButton.icon(onPressed: onPressed, icon: Icon(icon), label: text);
  }
}
