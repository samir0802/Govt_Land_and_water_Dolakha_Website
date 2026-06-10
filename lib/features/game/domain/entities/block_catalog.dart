import 'package:flutter/material.dart';

import '../../../../core/utils/color_utils.dart';
import 'block.dart';

class BlockCatalog {
  static List<Block> all({Color? color}) {
    final Color blockColor = color ?? ColorUtils.randomBlockColor();
    return <Block>[
      Block(id: 'line_2_h', shape: const <List<int>>[[1, 1]], color: blockColor),
      Block(id: 'line_2_v', shape: const <List<int>>[[1], [1]], color: blockColor),
      Block(id: 'line_3_h', shape: const <List<int>>[[1, 1, 1]], color: blockColor),
      Block(id: 'line_3_v', shape: const <List<int>>[[1], [1], [1]], color: blockColor),
      Block(id: 'l_3', shape: const <List<int>>[[1, 0], [1, 1]], color: blockColor),
      Block(id: 'square_4', shape: const <List<int>>[[1, 1], [1, 1]], color: blockColor),
      Block(id: 't_4', shape: const <List<int>>[[1, 1, 1], [0, 1, 0]], color: blockColor),
    ];
  }
}
