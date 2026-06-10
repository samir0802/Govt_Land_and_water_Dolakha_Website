import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../cubit/settings_cubit.dart';

class SettingsScreen extends StatelessWidget {
  const SettingsScreen({super.key});
  static const String routeName = '/settings';

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Settings')),
      body: BlocBuilder<SettingsCubit, SettingsState>(
        builder: (BuildContext context, SettingsState state) {
          return ListView(
            children: <Widget>[
              SwitchListTile(value: state.soundEnabled, onChanged: context.read<SettingsCubit>().toggleSound, title: const Text('Sound effects')),
              SwitchListTile(value: state.musicEnabled, onChanged: context.read<SettingsCubit>().toggleMusic, title: const Text('Music')),
              ListTile(
                title: const Text('Theme'),
                trailing: DropdownButton<ThemeMode>(
                  value: state.themeMode,
                  onChanged: (ThemeMode? value) {
                    if (value != null) context.read<SettingsCubit>().setThemeMode(value);
                  },
                  items: ThemeMode.values.map((ThemeMode mode) => DropdownMenuItem<ThemeMode>(value: mode, child: Text(mode.name))).toList(),
                ),
              ),
              ListTile(title: const Text('High Score'), trailing: Text('${state.highScore}')),
              ListTile(title: const Text('Extra Lives'), trailing: Text('${state.extraLives}')),
              ListTile(title: const Text('Hints'), trailing: Text('${state.hints}')),
              Padding(
                padding: const EdgeInsets.all(16),
                child: OutlinedButton(onPressed: context.read<SettingsCubit>().resetHighScore, child: const Text('Reset High Score')),
              ),
            ],
          );
        },
      ),
    );
  }
}
