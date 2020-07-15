<?php
header('Content-type: application/json; charset= UTF-8');
require_once './change_rules.php';
//先攻後攻、行番号、列番号取得
$player = $_GET['player'];
$row = (int)$_GET['row'];
$col = (int)$_GET['col'];


//元の盤面を取得
$path = './kyoku.json';
$json = file_get_contents($path);
$masu = json_decode($json, true);
//あとで変化したところだけ取得するために残しておく
$temp = $masu;

//ますの列を行として取得して０〜１５の行を取得
// $lines = toLine($masu);

// $lineAngle = angle45($masu, $row, $col);

//プレーン：０
//先攻：白：１
//後攻：黒：−１
if ($player === 'first') {
  $stone = 1;
} else {
  $stone = -1;
}

//盤面の変化（このタイミングではすでに石をおけるかの条件を満たしている）
  // if (-$stone === $masu[$row][$col-1] || -$stone === $masu[$row][$col+1]) {
  //   //変化した行
  //   $line = reverse($col, $lines[$row], $stone);
  //   //変化した行と列とななめのmasuを更新
  //   $masu[$row] = $line;
  // }
  //
  // if (-$stone === $masu[$row-1][$col] || -$stone === $masu[$row+1][$col]) {
  //   //変化した列
  //   $lineVer = reverse($row, $lines[$col + 8], $stone);
  //   //変化した行と列とななめのmasuを更新
  //   for ($i=0; $i < 8; $i++) {
  //     $masu[$i][$col] = $lineVer[$i];
  //   }
  // }

  $masu = angleReverse($masu, $row, $col, $stone);

  // if (-$stone === $masu[$row-1][$col-1] || -$stone === $masu[$row+1][$col+1]) {
  //   //変化した斜めライン１
  //   $lineAngleD = reverse($col, $lineAngle[0], $stone, count($lineAngle[0]));
  //   //変化した行と列とななめのmasuを更新
  //   $r = $row;
  //   $c = $col;
  //   while ($r >= 0 && $c >= 0) {
  //     $r--; $c--;
  //   }
  //   $cD = count($lineAngleD);
  //   if ($r < 0) {
  //     for ($i=0; $i < $cD; $i++) {
  //       $masu[$i][$i +8 -$cD] = $lineAngleD[$i];
  //     }
  //   } else {
  //     for ($i=0; $i < $cD; $i++) {
  //       $masu[$i +8 -$cD][$i] = $lineAngleD[$i];
  //     }
  //   }
  // }

  // if (-$stone === $masu[$row-1][$col+1] || -$stone === $masu[$row+1][$col-1]) {
  //   //変化した斜めライン２
  //   $lineAngleU = reverse($col, $lineAngle[1], $stone, count($lineAngle[1]));
  //   //変化した行と列とななめのmasuを更新
  //   $r = $row;
  //   $c = $col;
  //   while (0 <= $c) {
  //     $masu[$r][$c] = $lineAngleU[$c];
  //     $r++;
  //     $c--;
  //   }
  //   $r = $row -1;
  //   $c = $col +1;
  //   while ($c < count($lineAngleU)) {
  //     $masu[$r][$c] = $lineAngleU[$c];
  //     $r--;
  //     $c++;
  //   }
  // }

$masu[$row][$col] = 0;
//もし変なとこクリックしたら
if ($temp === $masu) {
  exit;
} else {
  $masu[$row][$col] = $stone;

  //結果が変化したものを取得、行番号->列番号の連想配列
  for ($i=0; $i < 8; $i++) {
    for ($j=0; $j < 8; $j++) {
      if ($temp[$i][$j] !== $masu[$i][$j]) {
        $hen[($i+1)*($j+1)] = $j;
      }
    }
  }

  if (count($hen) === 1) {
    exit;
  }

  //１ターンごとの結果、json_decode形式に、jsonファイルに記録
  $kekka = json_encode($masu);
  file_put_contents($path, $kekka);

  $kekka = json_encode($hen);

  echo $kekka;
}
