# Block Puzzle - Development Guide

## Project Overview
Flutter block puzzle game with rewarded video ads and in-app purchases. Uses Clean Architecture + BLoC.

## Commands
- `flutter pub get` - Install dependencies
- `flutter run` - Run on connected device
- `flutter test` - Run all tests
- `flutter build apk --release` - Build Android release

## Architecture Decision Record (ADR)
**State Management**: flutter_bloc with Cubit (simple game logic doesn't require full BLoC events)
**Dependency Injection**: get_it for service locator
**Local Storage**: shared_preferences for settings/highscore, sqflite for game state persistence
**Monetization**: google_mobile_ads v7.0+ for ads, RevenueCat (purchases_flutter) for IAP

## Coding Conventions
- Files: snake_case
- Classes: PascalCase
- Variables/methods: camelCase
- Constants: SCREAMING_SNAKE_CASE
- Private members: prefix with _
- BLoC naming: XxxCubit for logic, XxxState for states, no events unless async

## Testing Requirements
- Each Cubit must have unit tests covering 100% of state transitions
- Game logic (placement validation, row clearing, scoring) must have unit tests
- Widget tests for critical screens (GameScreen, ShopScreen)

## Critical Build Notes
- Always use AdMob TEST AD UNIT IDs during development
- RevenueCat MUST be initialized with API keys from environment variables
- iOS requires ATT prompt on first launch
- Android BILLING permission must be in manifest
