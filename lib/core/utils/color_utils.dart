import 'dart:math';
import 'package:flutter/material.dart';

class ColorUtils {
  static final List<Color> palette = <Color>[
    Colors.redAccent,
    Colors.orangeAccent,
    Colors.amberAccent,
    Colors.greenAccent,
    Colors.cyanAccent,
    Colors.blueAccent,
    Colors.purpleAccent,
    Colors.pinkAccent,
  ];

  static Color randomBlockColor([Random? random]) {
    final Random rng = random ?? Random();
    return palette[rng.nextInt(palette.length)];
  }
}
