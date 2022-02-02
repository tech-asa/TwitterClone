<?php

// ユーザーデータの処理

/**
 *  ユーザーを作成
 * 
 *  @param array $data
 *  @return bool
 */
function createUser(array $data)
{
    // DB接続
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // 接続エラーがある場合には処理を停止
    if ($mysqli->connect_errno) { // 直近の接続コールに関するエラーコードを返す
        echo 'MySQLの接続に失敗しました。:' . $mysqli->connect_error . "<br>"; //直近の接続エラーの説明を返す
        exit;
    }

    // 新規登録のSQLクエリを作成
    //?はplaceholderと言って後から値をセットできる。直接値が入るように設定すると意図しない処理が行われる可能性がある
    $query = 'INSERT INTO users (email, name, nickname, password) VALUES (?, ?, ?, ?)';

    // プリペアドステーメントに、作成したクエリを登録
    $statement = $mysqli->prepare($query);

    // パスワードをハッシュ値に変換
     //password_hash関数は端的いえばパスワードを暗号化する
    $date['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

    // クエリのplaceholder(?の部分)にカラム値を紐付け
    // bind_param の第一引数は、バインド変数の数だけ型 ( s = string, i = integer, d = double, b = blob) を指定する
    $statement->bind_param('ssss', $data['email'], $data['name'], $data['nickname'], $data['password']);

    // クエリを実行  //boolで返す
    $response = $statement->execute();
 
    // 実行に失敗した場合->エラー表示
    if ($response === false) {
        echo 'エラーメッセージ :' . $mysqli->error . "\n";
    }
 
    // DB接続を解放
    $statement->close();
    $mysqli->close();
 
    return $response;
}