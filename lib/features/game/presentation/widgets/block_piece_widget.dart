import 'package:flutter/material.dart';

import '../../domain/entities/block.dart';

class BlockPieceWidget extends StatelessWidget {
  const BlockPieceWidget({super.key, required this.block, this.cellSize = 24, this.draggable = true});

  final Block block;
  final double cellSize;
  final bool draggable;

  @override
  Widget build(BuildContext context) {
    final Widget child = _BlockShape(block: block, cellSize: cellSize);
    if (!draggable) return child;
    return Draggable<Block>(
      data: block,
      feedback: Material(color: Colors.transparent, child: _BlockShape(block: block, cellSize: cellSize * 1.1)),
      childWhenDragging: Opacity(opacity: 0.25, child: child),
      child: child,
    );
  }
}

class _BlockShape extends StatelessWidget {
  const _BlockShape({required this.block, required this.cellSize});

  final Block block;
  final double cellSize;

  @override
  Widget build(BuildContext context) {
    return Column(
      mainAxisSize: MainAxisSize.min,
      children: block.shape.map((List<int> row) {
        return Row(
          mainAxisSize: MainAxisSize.min,
          children: row.map((int cell) {
            return AnimatedContainer(
              duration: const Duration(milliseconds: 160),
              width: cellSize,
              height: cellSize,
              margin: const EdgeInsets.all(1.5),
              decoration: BoxDecoration(
                color: cell == 1 ? block.color : Colors.transparent,
                borderRadius: BorderRadius.circular(5),
                boxShadow: cell == 1 ? <BoxShadow>[BoxShadow(color: block.color.withOpacity(0.35), blurRadius: 6)] : null,
              ),
            );
          }).toList(),
        );
      }).toList(),
    );
  }
}
