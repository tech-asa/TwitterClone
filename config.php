<?php
// エラー表示あり
ini_set('display_errors',1);
// 日本時間にする
date_default_timezone_set('Asia/Tokyo');
// URL/ディレクトリ設定
define('HOME_URL','/');
// データベースの接続状況
define('DB_HOST','us-cdbr-east-05.cleardb.net'); //例： echo DB_HOST で localhost が出力される
define('DB_USER','b5ef6c01b244eb');
define('DB_PASSWORD','b5fa5a09');
define('DB_NAME','heroku_ba0a4750e6f509d');

// mysql://b5ef6c01b244eb:b5fa5a09@us-cdbr-east-05.cleardb.net/heroku_ba0a4750e6f509d?reconnect=true