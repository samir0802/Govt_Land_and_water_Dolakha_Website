import 'package:flutter/material.dart';

import '../../../../core/constants/app_constants.dart';
import '../../domain/entities/block.dart';

class GameBoardWidget extends StatelessWidget {
  const GameBoardWidget({super.key, required this.grid, required this.onBlockDropped, this.hintPosition});

  final List<List<Color?>> grid;
  final Future<bool> Function(Block block, int row, int column) onBlockDropped;
  final Point? hintPosition;

  @override
  Widget build(BuildContext context) {
    return AspectRatio(
      aspectRatio: 1,
      child: DragTarget<Block>(
        onWillAcceptWithDetails: (_) => true,
        onAcceptWithDetails: (DragTargetDetails<Block> details) {
          final RenderObject? renderObject = context.findRenderObject();
          if (renderObject is! RenderBox) return;
          final Offset local = renderObject.globalToLocal(details.offset);
          final double cellSize = renderObject.size.width / AppConstants.gridColumns;
          final int row = (local.dy / cellSize).floor();
          final int column = (local.dx / cellSize).floor();
          onBlockDropped(details.data, row, column);
        },
        builder: (BuildContext context, _, __) => CustomPaint(
          painter: _GameBoardPainter(grid: grid, hintPosition: hintPosition, colorScheme: Theme.of(context).colorScheme),
        ),
      ),
    );
  }
}

class _GameBoardPainter extends CustomPainter {
  const _GameBoardPainter({required this.grid, required this.colorScheme, this.hintPosition});

  final List<List<Color?>> grid;
  final ColorScheme colorScheme;
  final Point? hintPosition;

  @override
  void paint(Canvas canvas, Size size) {
    final double cellSize = size.width / AppConstants.gridColumns;
    final Paint paint = Paint();
    for (int row = 0; row < AppConstants.gridRows; row++) {
      for (int column = 0; column < AppConstants.gridColumns; column++) {
        final Rect rect = Rect.fromLTWH(column * cellSize + 2, row * cellSize + 2, cellSize - 4, cellSize - 4);
        final bool isHint = hintPosition?.row == row && hintPosition?.column == column;
        paint.color = grid[row][column] ?? (isHint ? colorScheme.primary.withOpacity(0.35) : colorScheme.surfaceContainerHighest);
        canvas.drawRRect(RRect.fromRectAndRadius(rect, const Radius.circular(8)), paint);
      }
    }
  }

  @override
  bool shouldRepaint(covariant _GameBoardPainter oldDelegate) => oldDelegate.grid != grid || oldDelegate.hintPosition != hintPosition || oldDelegate.colorScheme != colorScheme;
}
