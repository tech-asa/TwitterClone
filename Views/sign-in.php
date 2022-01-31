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
    <title>ログイン画面 / Twitterクローン</title>
    <meta name="description" content="ログイン画面です">
</head>
<body class="signup text-center">
    <main class="form-signup">
        <form action="sign-in.php" method="post">
            <img src="<?php echo HOME_URL;?>Views/img/logo-white.svg" alt="" class="logo-white">
             <h1>Twitterクローンにログイン</h1> 
            <input type="email" class="form-control" name="email" placeholder="メールアドレス" required autofocus>
            <input type="password" class="form-control" name="password" placeholder="パスワード" required>
            <!--⏬「w-100」はwidth100%を意味する、btnはBootstrapでボタン、lgは大きな、button type="submit"は送信ボタンで必須 -->
            <button class="w-100 btn btn-lg" type="submit">ログイン</button>
            <p class="mt-3 mb-2"><a href="sign-up.php">会員登録する</a></p>
            <p class="mt-2 mb-3 text-muted">&copy; 2021</p> <!-- text-mutedは文字を薄くする -->
        </form>
    </main>
    <?php include_once('../Views/common/foot.php'); ?>
</body>
</html>