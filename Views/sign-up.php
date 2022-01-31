<?php
//設定関連を読み込む
include_once('../config.php'); //他のファイルの読み込み(_onceをつけると一度しか読み込まなくなる)
//便利な関数を読み込む
include_once('../util.php');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include_once('../Views/common/head.php'); ?>
    <title>会員登録画面 / Twitterクローン</title>
    <meta name="description" content="会員登録画面です">
</head>
<body class="signup text-center">
    <main class="form-signup">
        <form action="sign-up.php" method="post">
            <img src="<?php echo HOME_URL;?>Views/img/logo-white.svg" alt="" class="logo-white">
             <h1>アカウントを作る</h1> <!--⏬「form-control」はBootstrapタグで基本的なフォーム、「placeholder」は枠内の初期値、
                                                「max-length」は最大文字数、「required」は必須入力、「autofocus」は自動で入力状態にする -->
            <input type="text" class="form-control" name="nickname" placeholder="ニックネーム" maxlength="50" required autofocus>
            <input type="text" class="form-control" name="name" placeholder="ユーザー名、例）techis132" maxlength="50" required>
            <input type="email" class="form-control" name="email" placeholder="メールアドレス" maxlength="254" required>
            <input type="password" class="form-control" name="password" placeholder="パスワード" minlength="4" maxlength="128" required>
            <!--⏬「w-100」はwidth100%を意味する、btnはBootstrapでボタン、lgは大きな、button type="submit"は送信ボタンで必須 -->
            <button class="w-100 btn btn-lg" type="submit">登録する</button>
            <p class="mt-3 mb-2"><a href="sign-in.php">ログインする</a></p>
            <p class="mt-2 mb-3 text-muted">&copy; 2021</p> <!-- text-mutedは文字を薄くする -->
        </form>
    </main>
    <?php include_once('../Views/common/foot.php'); ?>
</body>
</html>