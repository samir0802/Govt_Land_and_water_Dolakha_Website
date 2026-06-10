import 'package:block_puzzle/core/di/injection_container.dart';
import 'package:block_puzzle/main.dart';
import 'package:flutter/material.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:shared_preferences/shared_preferences.dart';

void main() {
  testWidgets('app launches main menu', (WidgetTester tester) async {
    SharedPreferences.setMockInitialValues(<String, Object>{'premium': true});
    await configureDependencies();
    await tester.pumpWidget(const BlockPuzzleApp());
    await tester.pump();
    expect(find.text('Block Puzzle'), findsOneWidget);
    expect(find.widgetWithText(FilledButton, 'Play'), findsOneWidget);
  });
}
