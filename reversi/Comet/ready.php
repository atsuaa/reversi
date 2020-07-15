<?php
// データを書き込むファイル
define('DATA_FILE', './player.json');
putData();

/*****ファンクション群*****/

//データを登録
function putData()
{
  $data = getData();
  $data = json_decode($data, true);
  if ($_GET['player'] === 'first') {
    $data['first'] = $_GET['id'];
  } elseif ($_GET['player'] === 'second') {
    $data['second'] = $_GET['id'];
  }
  $data = json_encode($data);
  file_put_contents(DATA_FILE, $data);
  // $n = 0;
  // while (!file_put_contents(DATA_FILE, $data, LOCK_EX) && $n <20) {
  //   echo $n;
	// 	$n++;
  // }

}

/**
 * データを取得
 */
function getData() {
	$contents = file_get_contents(DATA_FILE);
	return $contents;
}
