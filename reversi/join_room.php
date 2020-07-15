<?php
session_start();
$room = $_GET['room'];
unset($_SESSION['player_id']);
$player_id = rand(100, 999). rand(100, 999);
$_SESSION['player_id'] = $player_id;

//一人が参加したら他の人は入れないように
$json = file_get_contents('./room_player.json');
$file = json_decode($json, true);
$file[$room] = $player_id;
$file = json_encode($file);
file_put_contents('./room_player.json', $file);

header("Location: ./space.php?room=$room&player_id=$player_id");
