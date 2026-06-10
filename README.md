# Block Puzzle

A production-ready Flutter block puzzle game scaffold built with Clean Architecture, BLoC/Cubit state management, `CustomPaint` rendering, rewarded ads, banner/interstitial ads, and RevenueCat in-app purchases.

## Features

- 8x8 block puzzle board rendered with `CustomPaint`.
- Drag-and-drop block tray using Flutter `Draggable` and `DragTarget`.
- Cubit-managed gameplay for move validation, scoring, row clearing, hints, score multipliers, revives, and game-over detection.
- High-score and settings persistence through `shared_preferences`.
- Google Mobile Ads test IDs for banner, interstitial, and rewarded ads.
- RevenueCat wrappers for Remove Ads, Extra Life Pack, and Hint Pack purchases.
- Light, dark, and system theme support.
- Unit and widget tests for core business logic and launch flow.

## Setup

1. Install Flutter 3.22+ and platform toolchains.
2. Install dependencies:

   ```bash
   flutter pub get
   ```

3. Configure Firebase:
   - Create a Firebase project.
   - Register Android app ID `com.example.blockpuzzle`.
   - Register the iOS bundle ID you configure in Xcode.
   - Download `google-services.json` into `android/app/`.
   - Download `GoogleService-Info.plist` into `ios/Runner/`.

4. Configure AdMob:
   - Create an AdMob app.
   - Create banner, interstitial, and rewarded ad units.
   - Replace the test IDs in `lib/services/ad_service.dart` before release.
   - Replace manifest and plist AdMob app IDs in `android/app/build.gradle` and `ios/Runner/Info.plist`.

5. Configure RevenueCat:
   - Create a RevenueCat project.
   - Add entitlement `premium`.
   - Create/link products:
     - `remove_ads` non-consumable, $4.99 USD.
     - `extra_life_pack` consumable, $0.99 USD.
     - `hint_pack` consumable, $0.99 USD.
   - Connect App Store Connect and Google Play Console.
   - Provide public SDK keys at build time:

   ```bash
   flutter run --dart-define=REVENUECAT_ANDROID_KEY=your_android_key --dart-define=REVENUECAT_IOS_KEY=your_ios_key
   ```

## Running

```bash
flutter run
```

## Testing

```bash
flutter test
```

## Android Build

```bash
flutter build apk --release --dart-define=REVENUECAT_ANDROID_KEY=your_android_key
```

## iOS Build

```bash
flutter build ios --release --dart-define=REVENUECAT_IOS_KEY=your_ios_key
```

## Release Checklist

- Replace all AdMob test IDs with production IDs.
- Verify RevenueCat offerings and entitlement names.
- Add Firebase config files.
- Verify App Tracking Transparency copy and SKAdNetwork IDs.
- Configure real Android signing keys and iOS signing profiles.
- Run `flutter test` and platform release builds.
