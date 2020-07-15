$(function(){
  //td要素のサイズをレスポンシブに調整
  var $h = $('#t').width() / 8 -2;
  console.log($h);
  $('td').css({
    'width': $h,
    'height': $h
  });



  //オセロの初期化
  $('#ready').click(function(){
    $('tr:eq(3)').children('td:eq(3)').find('div').addClass('b');
    $('tr:eq(3)').children('td:eq(4)').find('div').addClass('w');
    $('tr:eq(4)').children('td:eq(3)').find('div').addClass('w');
    $('tr:eq(4)').children('td:eq(4)').find('div').addClass('b');

    //syokika.phpファイルでjsonデータも初期化
    Syokika();
    var $player = $('option:selected').val();
    // if ($player === 'second') {
    //   $('#mask').toggle();
    // }

    //ターンにfirstをセット
    $.get({
      url: './turn.php',
      data: {"player": $player, "ready": "first"}
    });
  });

//画面を開いたらturnを初期化
$.get({
  url: './turn_syokika.php'
}).done(function(){
  console.log('turn情報を初期化');
});

function Syokika() {
  $.get({
    url: './syokika.php',
  }).done(function(data){
    if (data == 'success') {
      console.log('JSONファイル[ボード]を初期化しました。');
      // $('#jyun').fadeOut();
      $('#restart').fadeIn();
    } else {
      console.log('JSONファイル[ボード]の初期化に失敗しました。');
    }
  }).fail(function(){
    console.log('[ボード]通信に失敗しました。');
  });
}

  //クリックさえたときの動き
  $('td').click(function(){
    $('td').removeClass('cursur');
    var that = this;
    var $s = $(this).children('div');
    if ($s.hasClass('b') || $s.hasClass('w')) {
      window.alert('すでに置いてあります！ありま〜す！');
    } else {
      //プレイヤー 情報
      var $player = $('option:selected').val();
      if ($player == 'first') {
        var $me = 'w';
        var $you = 'b';
      } else {
        var $me = 'b';
        var $you = 'w';
      }
      console.log($player);

      //インデックスの取得
      //行
      var $row = $(this).closest('tr').index();
      //列
      var $col = this.cellIndex;
      console.log($row);
      console.log($col);

      $.getJSON({
        url: './reversi.php',
        data: {'player': $player, 'row': $row, 'col': $col}
      }).done(
        function(data){
          console.log(data);
          var $keys = Object.keys(data);
          console.log($keys);
          for (var i = 0; i < $keys.length; i++) {
            var $d = data[$keys[i]];

            var k = $keys[i]/($d+1) - 1;
            console.log(k);
            $('tr:eq('+k+')').children('td:eq('+$d+')').find('div').addClass($me).removeClass($you);

            // //ターン
            // $.get({
            //   url: './turn.php',
            //   data: {"player": $player}
            // });
          }
        }
      ).fail(
        function (jqXHR, textStatus, errorThrown) {
          console.log('fail');
          console.log("jqXHR          : " + jqXHR.status); // HTTPステータスが取得
          console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラー
          console.log("errorThrown    : " + errorThrown.message); // 例外情報
          $(that).addClass('cursur');
        }
      );


    }






  });


//READYの後に出る「やり直す」ボタン
$('#restart').find('button').click(function(){
 var $con = window.confirm('ほんとうにやり直しますか？');
 if ($con) {
   $.get({
     url: './syokika_p.php',
   }).done(function(data){
     if (data == 'success') {
       console.log('JSONファイル[プレーヤー]を初期化しました。');
     } else {
       console.log('JSONファイル[プレーヤー]の初期化に失敗しました。');
     }
   }).fail(function(){
     console.log('[プレーヤー]通信に失敗しました。');
   });

   Syokika_noFade();
   reset();

   $('#restart').fadeOut();
   $('#jyun').fadeIn();
 }
});





});

function Syokika_noFade() {
  $.get({
    url: './syokika.php',
  }).done(function(data){
    if (data == 'success') {
      console.log('JSONファイル[ボード]を初期化しました。');
    } else {
      console.log('JSONファイル[ボード]の初期化に失敗しました。');
    }
  }).fail(function(){
    console.log('[ボード]通信に失敗しました。');
  });
}

function reset() {
  $('#t div').removeClass('w').removeClass('b');
  $('tr:eq(3)').children('td:eq(3)').find('div').addClass('b');
  $('tr:eq(3)').children('td:eq(4)').find('div').addClass('w');
  $('tr:eq(4)').children('td:eq(3)').find('div').addClass('w');
  $('tr:eq(4)').children('td:eq(4)').find('div').addClass('b');

  var $p = $('#player');
  $p.fadeOut();
  $p.find('#fir').text('');
  $p.find('#sec').text('');
}
