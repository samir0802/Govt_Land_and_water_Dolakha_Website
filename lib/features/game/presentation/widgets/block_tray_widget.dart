import 'package:flutter/material.dart';

import '../../domain/entities/block.dart';
import 'block_piece_widget.dart';

class BlockTrayWidget extends StatelessWidget {
  const BlockTrayWidget({super.key, required this.blocks});

  final List<Block> blocks;

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      height: 116,
      child: ListView.separated(
        padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
        scrollDirection: Axis.horizontal,
        itemBuilder: (BuildContext context, int index) => Card(
          child: Padding(padding: const EdgeInsets.all(12), child: Center(child: BlockPieceWidget(block: blocks[index]))),
        ),
        separatorBuilder: (_, __) => const SizedBox(width: 12),
        itemCount: blocks.length,
      ),
    );
  }
}
