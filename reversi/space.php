<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="script.js" charset="utf-8"></script>
    <script src="./Comet/ready.js" charset="utf-8"></script>
    <script src="board_rules.js" charset="utf-8"></script>
    <title>リバーシ作ったよ</title>
  </head>
  <body>
<?php
$room = $_GET['room'];

//マスター管理用のjsonファイル
$master = file_get_contents('./room_master.json');
$master = json_decode($master, true);
 ?>
    <div class="main">
      <div class="left">
        <?php
         if (($_SESSION['type'] === 'master' && $_SESSION['master_id'] === $master[$room])
            || $_SESSION['player_id'] === $_GET['player_id']):?>

        <div id="jyun">
          <span>好きな名前を入れてね</span>
          <input type="text" name="id" value="Guest">
          <span>順番を決めよう</span>
          <select name="">
            <option value="first">先攻</option>
            <option value="second">後攻</option>
          </select>
          <span>準備完了？</span>
          <button type="button" id="ready">READY</button>
        </div>

      <?php endif; ?>

        <div id="restart" style="display: none">
          <button type="button" name="button">やり直す</button>
        </div>

        <div id="player" style="display: none">
          <span>先攻： <span id="fir"></span> </span>
          <span>後攻： <span id="sec"></span> </span>
        </div>


        <div class="board">
          <table id="t">

            <?php for ($i=0; $i < 8; $i++): ?>
            <tr>
              <?php for ($j=0; $j < 8; $j++): ?>
              <td><div></div></td>
              <?php endfor; ?>
            </tr>
          <?php endfor; ?>
          </table>
          <div id="mask"> <p>相手の番です</p> </div>
        </div>

        <div id="game">
          <p>ゲーム結果を表示する</p>
          <button type="button" name="button">結果を表示</button>
        </div>
      </div>

      <div class="right">
        <div id="pass">
          <p>パス</p>
        </div>
        <div id="game-point">
          <p>得点を確認</p>
        </div>
        <div id="game-kekka" style="display: none">
          <p class="white">白： <span></span> </p>
          <p class="black">黒： <span></span> </p>
        </div>
      </div>
    </div>

<!-- マスターはここからルームを削除する -->
    <?php
     if ($_SESSION['type'] === 'master' && $_SESSION['master_id'] === $master[$room]):?>

        <div class="delete">
          <a href="./delete.php?room=<?= $_GET['room'] ?>">ルームを終了する。</a>
        </div>

  <?php endif; ?>

<!-- 対戦相手はここからルームを抜ける -->
    <?php
     if ($_SESSION['player_id'] === $_GET['player_id']):?>

        <div class="delete">
          <a href="./exit.php?room=<?= $_GET['room'] ?>">ルームから抜ける。</a>
        </div>

  <?php endif; ?>


  </body>
</html>
