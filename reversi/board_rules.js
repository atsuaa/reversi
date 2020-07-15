$(function(){
var $player = $('option:selected').val();
  //どこにも置けない場合はパス
  $('#pass').click(function(){
    // var $player = $('option:selected').val();
    $.get({
      url: './turn.php',
      data: {"player": $player}
    });
  });



  //終了したら結果を表示するボタンが出現
  $('#game-point').click(function(){
    var $masu = 0;
    $('td').each(function(){
      var $ishi = $(this).find('div');
      if ($ishi.hasClass('w') || $ishi.hasClass('b')) {
        $masu++;
      }
    });
    if ($masu >= 6) {
      gameSet();
    } else {
      if (window.confirm('ここで終了しますか？')) {
        gameSet();
      }
    }
  });

function gameSet() {
  $.getJSON({
    url:'kyoku.json'
  }).done(function(data){
    var w = 0;
    var b = 0;
    for (var i = 0; i < 8; i++) {
      for (var j = 0; j < 8; j++) {
        if (data[i][j] === 1) {
          w++;
        } else if (data[i][j] === -1) {
          b++;
        }
      }
    }
    $('.white').find('span').text(w);
    $('.black').find('span').text(b);
    $('#game-kekka').fadeIn();
    if ($player === 'first' && w>b) {
      $('#game-kekka').append('<p>勝利！！</p>');
    } else if (w === b) {
      $('#game-kekka').append('<p>引き分け</p>');
    } else {
      $('#game-kekka').append('<p>まあこんな日もあるさ</p>');
    }

  });
}



  //結果表示ボタンを押したら特典と勝敗を表示
});
