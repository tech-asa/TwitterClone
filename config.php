<?php
// エラー表示あり
ini_set('display_errors',1);
// 日本時間にする
date_default_timezone_set('Asia/Tokyo');
// URL/ディレクトリ設定
define('HOME_URL','/TwitterClone/');
// データベースの接続状況
define('DB_HOST','localhost'); //例： echo DB_HOST で localhost が出力される
define('DB_USER','root');
define('DB_PASSWORD','root');
define('DB_NAME','twitter_clone');