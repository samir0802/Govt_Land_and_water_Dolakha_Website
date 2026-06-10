import 'package:block_puzzle/features/game/domain/entities/block.dart';
import 'package:flutter/material.dart';
import 'package:flutter_test/flutter_test.dart';

void main() {
  test('counts occupied cells and rotates shape clockwise', () {
    const Block block = Block(id: 'l', color: Colors.red, shape: <List<int>>[
      <int>[1, 0],
      <int>[1, 1],
    ]);

    expect(block.cellCount, 3);
    expect(block.occupiedCells(), const <Point>[Point(0, 0), Point(1, 0), Point(1, 1)]);
    expect(block.rotatedClockwise().shape, <List<int>>[
      <int>[1, 1],
      <int>[1, 0],
    ]);
  });
}
