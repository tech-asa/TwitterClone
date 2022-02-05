<?php

// ユーザーデータの処理

/**
 *  ユーザーを作成
 * 
 *  @param array $data
 *  @return bool //論理式(TRUE,FALSE)
 */
function createUser(array $data)
{
    // DB接続 テーブルに乗せるイメージ
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); //インスタンス化

    // 接続エラーがある場合には処理を停止
    if ($mysqli->connect_errno) { // 直近の接続コールに関するエラーコードを返す場合
        echo 'MySQLの接続に失敗しました。:' . $mysqli->connect_error . "<br>"; //直近の接続エラーの説明を返す
        exit;
    }

    // 新規登録のSQLクエリを作成 $queryは普通の変数
    //?はplaceholderと言って後から値をセットできる。直接値が入るように設定すると意図しない処理が行われる可能性がある
    $query = 'INSERT INTO users (email, name, nickname, password) VALUES (?, ?, ?, ?)';

    // プリペアドステーメントに、作成したクエリを登録 $statementは普通の変数
    $statement = $mysqli->prepare($query);

    // パスワードをハッシュ値に変換
    //password_hash関数は端的いえばパスワードを暗号化する
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    // クエリのplaceholder(?の部分)にカラム値を紐付け
    // bind_param の第一引数は、バインド変数の数だけ型 ( s = string, i = integer, d = double, b = blob) を指定する
    $statement->bind_param('ssss', $data['email'], $data['name'], $data['nickname'], $data['password']);

    // クエリを実行  //boolで返す
    $response = $statement->execute();
 
    // 実行に失敗した場合->エラー表示
    if ($response === false) {
        echo 'エラーメッセージ :' . $mysqli->error . "\n";
    }
 
    // DB接続を解放(解除)
    $statement->close();
    $mysqli->close();
 
    //最終的に返す値(boolで)
    return $response;
}

/**
 * 
 * @param string $email
 * @param string $password
 * @return array | false
 */

function findUserAndCheckPassword(string $email,string $password)
{    
    // DB接続 テーブルに乗せるイメージ
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); //インスタンス化

    // 接続エラーがある場合には処理を停止
    if ($mysqli->connect_errno) { // 直近の接続コールに関するエラーコードを返す場合
        echo 'MySQLの接続に失敗しました。:' . $mysqli->connect_error . "<br>"; //直近の接続エラーの説明を返す
        exit;
    }
    
    // 入力値のエスケープ(エスケープをすることによってアドレス内で意図しないプログラムが処理されないようにする)
    $email = $mysqli->real_escape_string($email);
    
    // SQLクエリの作成
    // 外部からのリクエストは何が入ってくるか不明なので、必ず、エスケープしたものをクオートで囲む
    $query = 'SELECT * FROM users WHERE email = "' . $email . '"';

    // クエリの実行
    $result = $mysqli->query($query);

    // クエリの実行に失敗した場合->return
    if (!$result) {
        // MySQL処理中にエラー発生
        echo 'エラーメッセージ:'.$mysqli->error."<br>";
        $mysqli->close();
        return false;
    }

    // ユーザー情報の取得
    $user = $result->fetch_array(MYSQLI_ASSOC);
    // ユーザーが存在しない場合->return
    if (!$user) {
        $mysqli->close();
        return false;
    }
    // パスワードチェック、不一致の場合->return
    if (!password_verify($password,$user['password'])) {
        $mysqli->close();
        return false;
    }

    // DB接続の解放
    $mysqli->close();

    return $user;
}
