import 'package:equatable/equatable.dart';
import 'package:flutter/material.dart';

class Block extends Equatable {
  const Block({required this.id, required this.shape, required this.color});

  final String id;
  final List<List<int>> shape;
  final Color color;

  int get rowCount => shape.length;
  int get columnCount => shape.isEmpty ? 0 : shape.first.length;
  int get cellCount => shape.fold<int>(0, (sum, row) => sum + row.where((cell) => cell == 1).length);

  List<Point> occupiedCells() {
    final List<Point> cells = <Point>[];
    for (int row = 0; row < shape.length; row++) {
      for (int column = 0; column < shape[row].length; column++) {
        if (shape[row][column] == 1) {
          cells.add(Point(row, column));
        }
      }
    }
    return cells;
  }

  Block rotatedClockwise() {
    if (shape.isEmpty) return this;
    final int rows = rowCount;
    final int columns = columnCount;
    final List<List<int>> rotated = List<List<int>>.generate(
      columns,
      (int row) => List<int>.generate(rows, (int column) => shape[rows - column - 1][row]),
    );
    return Block(id: '${id}_rotated', shape: rotated, color: color);
  }

  @override
  List<Object?> get props => <Object?>[id, shape, color];
}

class Point extends Equatable {
  const Point(this.row, this.column);

  final int row;
  final int column;

  @override
  List<Object?> get props => <Object?>[row, column];
}
