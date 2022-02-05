<?php

// サインインコントローラー

//設定の読み込み
include_once '../config.php';
// 便利の関数の読み込み
include_once '../util.php';

//ユーザーモデルデータを読み込み
include_once '../Models/users.php';

// ログイン結果
$try_login_result = null;

// メールアドレスとパスワードが入力されている場合
if (isset($_POST['email']) && isset($_POST['password'])) {
    // ログインチェックを実行
    $user = findUserAndCheckPassword($_POST['email'],$_POST['password']);
    // ログインに成功した場合
    if ($user) {
        // ユーザー情報をセッションに保存
        saveUserSession($user);
        // ホーム画面へ遷移
        header('Location:'.HOME_URL.'Controllers/home.php'); //headerでブラウザに直接働くようにする
        exit;
    } else {  //ログインに失敗した場合
        $try_login_result = false;
    }
}

// 表示用の変数
$view_try_login_result = $try_login_result;

// 画面表示
include_once '../Views/sign-in.php';