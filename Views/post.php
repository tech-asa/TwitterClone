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
    <title>つぶやく画面 / Twitterクローン</title>
    <meta name="description" content="つぶやく画面です">
</head>

<body class="home">
    <div class="container">
        <?php include_once('../Views/common/side.php'); ?>
        <!-- メインの全体 -->
        <div class="main">
            <!-- メインのヘッダー -->
            <div class="main-header">
                <h1 class="">つぶやく</h1>
            </div>
            
            <!-- つぶやき投稿エリア -->
            <div class="tweet-post">
                <div class="my-icon">
                    <img src="<?php echo HOME_URL; ?>Views/img_uploaded/user/sample-person.jpg" alt="">
                </div>
                <!-- 投稿部分 -->
                <div class="input-area">
                    <!-- ①投稿先のファイル ②投稿方法(主にpost) ③ファイルに関しての詳しい情報を知ることができるようになる（なしの場合ファイル名しか得られない） -->
                    <form action="post.php" method="post" enctype="multipart/form-data">
                        <!-- ①input textは1行、textareaは複数行 ②初期値 ③最大文字数 -->
                        <textarea name="body" placeholder="いまどうしてる？" maxlength="140"></textarea>
                        <div class="bottom-area">
                            <!-- mb-0は、Bootstrapで margin-bottom:0px の意味 -->
                            <div class="mb-0">
                            <!-- form-controlでinputとtextareaにカスタムスタイル、サイズなどができる smは「small」でサイズが小さくなる -->
                                <input type="file" name="image" class="form-control form-control-sm">
                            </div>
                            <!-- input type="button"ではなく<button type="submit"が一般的(CSSが反映させやすいから) -->
                            <!-- class="btn"でBootstrapのボタン種類が反映される(btn-〇〇という様々な種類がある) -->
                            <button type="submit" class="btn">つぶやく</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 仕切りエリア -->
            <div class="ditch"></div>
        </div>
    </div>
<?php include_once('../Views/common/foot.php'); ?>

</body>
</html>