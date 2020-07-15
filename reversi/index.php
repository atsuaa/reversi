<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="./make_room.js" charset="utf-8"></script>
    <title>リバーシ作ったよ</title>
  </head>
  <body>
    <h1>リバーシ</h1>
    <?php if ($_GET['exit']): ?>
      <span><?= $_GET['exit'] ?>はすでに作成されています。</span>
    <?php endif; ?>
    <form class="make-room" action="./room.php" method="post">
      <span>ルームを作成する。</span>
      <select class="" name="room">
        <option value="001">001</option>
        <option value="002">002</option>
        <option value="003">003</option>
      </select>
      <input type="submit" value="作成して入室">
    </form>
    <hr>

    <div class="rooms">

    </div>
    <hr>

  </body>
</html>
