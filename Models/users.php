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
* ユーザーを更新
*
* @param array $data
* @return bool
*/
function updateUser(array $data)
{
    // DB接続
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_errno) {
        echo 'MySQLの接続に失敗しました。：' . $mysqli->connect_error . "\n";
        exit;
    }
    
    // 更新日時を保存データに追加
    $data['updated_at'] = date('Y-m-d H:i:s');
    
    // パスワードがある場合->ハッシュ値に変換
    if (isset($data['password'])) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    }
    
    // ------------------------------------
    // SQLクエリを作成（更新）
    // ------------------------------------
    // SET句のカラムを準備
    $set_columns = [];
    foreach ([
        'name', 'nickname', 'email', 'password', 'image_name', 'updated_at'
    ] as $column) {
        // 入力があれば、更新の対象にする
        if (isset($data[$column]) && $data[$column] !== '') {
            $set_columns[] = $column . ' = "' . $mysqli->real_escape_string($data[$column]) . '"';
        }
    }
    
    // クエリ組み立て
    $query = 'UPDATE users SET ' . join(',', $set_columns);
    $query .= ' WHERE id = "' . $mysqli->real_escape_string($data['id']) . '"';
    
    // ------------------------------------
    // 戻り値を作成
    // ------------------------------------
    // クエリを実行
    $response = $mysqli->query($query);
    
    // SQLエラーの場合->エラー表示
    if ($response === false) {
        echo 'エラーメッセージ：' . $mysqli->error . "\n";
    }
    
    // ------------------------------------
    // 後処理
    // ------------------------------------
    // DB接続を開放
    $mysqli->close();
    
    return $response;
}
    
/**
 * ユーザー情報取得：ログインチェック
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

/**
 * ユーザーを一件取得
 * 
 * @param int $user_id
 * @param int $login_user_id
 * @return array|false
 */
function findUser(int $user_id, int $login_user_id = null)
{
    //DB接続
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    if ($mysqli->connect_errno) {
        echo 'MySQLの接続に失敗しました。:'.$mysqli->connect_error."\n";
        exit;
    }

    // エスケープ(SQLインジェクション対策)
    $user_id = $mysqli->real_escape_string($user_id);
    $login_user_id = $mysqli->real_escape_string($login_user_id);

    //--------------------------------
    // SQLクエリの作成(検索)
    //--------------------------------
    $query = <<<SQL
        SELECT
            U.id,
            U.name,
            U.nickname,
            U.email,
            U.image_name,
            -- フォロー中の数
            (SELECT COUNT(1)FROM follows WHERE status = 'active' AND follow_user_id = U.id)AS follow_user_count,
            -- フォロワーの数
            (SELECT COUNT(1)FROM follows WHERE status = 'active' AND followed_user_id = U.id)AS followed_user_count,
            -- ログインユーザーがフォローしている場合、フォローIDが入る
            F.id AS follow_id
        FROM
            users AS U LEFT JOIN follows AS F
                ON F.status = 'active' AND F.followed_user_id = '$user_id' AND F.follow_user_id = '$login_user_id'
            -- users AS U CROSS JOIN (SELECT * FROM follows WHERE status = 'active' AND followed_user_id = '$user_id' AND follow_user_id = '$login_user_id') AS F
        WHERE
            U.status = 'active' AND U.id = '$user_id'
    SQL;

    //--------------------------------
    // 戻り値の作成
    //--------------------------------
    // クエリを実行し、SQLエラーでない場合
    if ($result = $mysqli->query($query)) {
        // 戻り値用の変数にセット：ユーザー情報一件
        $response = $result->fetch_array(MYSQLI_ASSOC);
    } else {
        // 戻り値用の変数にセット：失敗
        $response = false;
        echo 'エラーメッセージ:'.$mysqli->error."\n";
    }

    //--------------------------------
    // 後処理
    //--------------------------------
    // DB接続を解放
    $mysqli->close();

    return $response;
}
