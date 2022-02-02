<?php

// サインアップコントローラー

// 設定の読み込み
include_once '../config.php';
// 便利な関数を読み込む
include_once '../util.php';
// ユーザーデータ操作モデルの読み込み
include_once '../Models/users.php';

// 登録項目が全て入力されていれば
if(isset($_POST['nickname']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])){
    $data = [ //一つの配列にまとめる
        'nickname' => $_POST['nickname'],
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
    ];
    // ユーザーを作成し、成功すれば
    if (createUser($data)) {
        // ログイン画面に遷移(無事に作成できれば下記のURLにつなぐ)
        header('Location:'.HOME_URL.'Controllers/sign-in.php');
        //「header」はブラウザに命令できる。「Location」はそれ以降のアドレスに遷移させる
        exit;
    }
}

// 画面表示(ユーザー作成に成功してない限り下記のURLが表示され続ける)
include_once '../Views/sign-up.php';