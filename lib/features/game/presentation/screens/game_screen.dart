import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../../../ads/presentation/cubit/ad_cubit.dart';
import '../cubit/game_cubit.dart';
import '../cubit/game_state.dart';
import '../widgets/block_tray_widget.dart';
import '../widgets/game_board_widget.dart';

class GameScreen extends StatefulWidget {
  const GameScreen({super.key});

  static const String routeName = '/game';

  @override
  State<GameScreen> createState() => _GameScreenState();
}

class _GameScreenState extends State<GameScreen> {
  @override
  void initState() {
    super.initState();
    context.read<GameCubit>().startGame();
    context.read<AdCubit>().loadRewardedAd();
  }

  @override
  Widget build(BuildContext context) {
    return BlocListener<AdCubit, AdState>(
      listener: (BuildContext context, AdState adState) {
        if (adState.status != AdStatus.rewarded) return;
        switch (adState.rewardType) {
          case AdRewardType.extraLife:
            context.read<GameCubit>().reviveGame();
            break;
          case AdRewardType.hint:
            context.read<GameCubit>().findHint();
            break;
          case AdRewardType.scoreMultiplier:
            context.read<GameCubit>().activateScoreMultiplier();
            break;
          case null:
            break;
        }
      },
      child: Scaffold(
        appBar: AppBar(
          title: const Text('Block Puzzle'),
          actions: <Widget>[IconButton(onPressed: () => Navigator.of(context).pushNamed('/settings'), icon: const Icon(Icons.settings))],
        ),
        body: BlocConsumer<GameCubit, GameState>(
          listener: (BuildContext context, GameState state) {
            if (state.errorMessage != null) {
              ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(state.errorMessage ?? 'Unknown error')));
            }
          },
          builder: (BuildContext context, GameState state) {
            if (state.status == GameStatus.loading) return const Center(child: CircularProgressIndicator());
            return SafeArea(
              child: Column(
                children: <Widget>[
                  Padding(
                    padding: const EdgeInsets.all(16),
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.spaceAround,
                      children: <Widget>[
                        _ScorePill(label: 'Score', value: state.score),
                        _ScorePill(label: 'Best', value: state.highScore),
                      ],
                    ),
                  ),
                  Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 16),
                    child: GameBoardWidget(
                      grid: state.grid,
                      hintPosition: state.hintPosition,
                      onBlockDropped: (block, row, column) => context.read<GameCubit>().placeBlock(block, row, column),
                    ),
                  ),
                  if (state.status == GameStatus.gameOver) _GameOverPanel(canRevive: state.canRevive) else BlockTrayWidget(blocks: state.blocks),
                  const Spacer(),
                  Padding(
                    padding: const EdgeInsets.only(bottom: 12),
                    child: Wrap(
                      alignment: WrapAlignment.center,
                      spacing: 8,
                      children: <Widget>[
                        OutlinedButton.icon(
                          onPressed: () => context.read<AdCubit>().showRewardedAd(AdRewardType.hint),
                          icon: const Icon(Icons.lightbulb),
                          label: const Text('Hint Ad'),
                        ),
                        OutlinedButton.icon(
                          onPressed: () => context.read<AdCubit>().showRewardedAd(AdRewardType.scoreMultiplier),
                          icon: const Icon(Icons.bolt),
                          label: const Text('2x Score'),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            );
          },
        ),
      ),
    );
  }
}

class _ScorePill extends StatelessWidget {
  const _ScorePill({required this.label, required this.value});

  final String label;
  final int value;

  @override
  Widget build(BuildContext context) {
    return Card(
      child: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 12),
        child: Column(children: <Widget>[Text(label), Text('$value', style: Theme.of(context).textTheme.headlineSmall)]),
      ),
    );
  }
}

class _GameOverPanel extends StatelessWidget {
  const _GameOverPanel({required this.canRevive});

  final bool canRevive;

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(16),
      child: Column(
        children: <Widget>[
          Text('Game Over', style: Theme.of(context).textTheme.headlineMedium),
          const SizedBox(height: 8),
          Wrap(
            spacing: 8,
            children: <Widget>[
              FilledButton(onPressed: () => context.read<GameCubit>().startGame(), child: const Text('Play Again')),
              OutlinedButton(
                onPressed: canRevive ? () => context.read<AdCubit>().showRewardedAd(AdRewardType.extraLife) : null,
                child: const Text('Watch Ad to Revive'),
              ),
            ],
          ),
        ],
      ),
    );
  }
}
