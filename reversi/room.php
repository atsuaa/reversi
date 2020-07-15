<?php
session_start();
$room = $_POST['room'];

//ルームがすでに作成されているかチェック
$file = file_get_contents('./make_room.json');
$file = json_decode($file, true);
if (in_array($room, $file)) {
  header("Location: ./index.php?exit=$room");
  exit;
}


$master_id = rand(100, 999). rand(100, 999);

$_SESSION['room'] = $room;
$_SESSION['type'] = 'master';
$_SESSION['master_id'] = $master_id;

//部屋番号を追加
$file = file_get_contents('./make_room.json');
$file = json_decode($file);
array_push($file, $room);
$file = json_encode($file);
file_put_contents('./make_room.json', $file);

//マスター管理用のjsonファイル
$file = file_get_contents('./room_master.json');
$file = json_decode($file, true);
$array = ["$room" => "$master_id"];
$file = array_merge($file, $array);
$file = json_encode($file);
file_put_contents('./room_master.json', $file);

//部屋にくるプレイヤー用のjsonファイル
$file = file_get_contents('./room_player.json');
$file = json_decode($file, true);
$array = ["$room" => ''];
$file = array_merge($file, $array);
$file = json_encode($file);
file_put_contents('./room_player.json', $file);


header("Location: ./space.php?room=$room");
