<?php
//設定関連を読み込む
include_once('../config.php'); //他のファイルの読み込み(_onceをつけると一度しか読み込まなくなる)
//便利な関数を読み込む
include_once('../util.php');

// ツイート一覧
// 配列を入れる（関数$の中に[]で配列を入れる）
$view_tweets = [
    [
        'user_id' => 1,
        'user_name' => 'taro',
        'user_nickname' => '太郎',
        'user_image_name' => 'sample-person.jpg',
        'tweet_body' => '今プログラミングをしています。',
        'tweet_image_name' => null,
        'tweet_created_at' => '2021-03-15 14:00:00',
        'like_id' => null,
        'like_count' => 0,
    ],
    [
        'user_id' => 2,
        'user_name' => 'jiro',
        'user_nickname' => '次郎',
        'user_image_name' => null,
        'tweet_body' => 'コワーキングスペースを作成しました!',
        'tweet_image_name' => 'sample-post.jpg',
        'tweet_created_at' => '2021-03-14 14:00:00',
        'like_id' => 1,
        'like_count' => 1,
    ]
];

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include_once('../Views/common/head.php'); ?>
    <title>ホーム画面 / Twitterクローン</title>
    <meta name="description" content="ホーム画面です">
</head>
<body class="home">
    <div class="container">
        <?php include_once('../Views/common/side.php'); ?>
        <!-- メインの全体 -->
        <div class="main">
            <!-- メインのヘッダー -->
            <div class="main-header">
                <h1 class="">ホーム</h1>
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

            <!-- つぶやき一覧エリア -->
            <!-- 真の場合 -->
            <?php if(empty($view_tweets)):?>
                <!-- 下記の”p-3”はBootstrapの関数 -->
                <p class="p-3">ツイートがありません</p>
            <!-- 偽(ツイートがある場合) -->
            <?php else:?>
                <div class="tweet-list">
                <!-- foreachを使って上の配列を組み込む -->
                    <?php foreach($view_tweets as $view_tweet): ?> 
                        <!-- この場合asで配列を$view_tweetに組み込んだ
                        $view_tweet部分がもし $00 => $11 だった場合は 「配列名」と「その値」を使うことができる -->
                        <?php include('../Views/common/tweet.php'); ?>
                    <!-- foreach文の最後を示す -->    
                    <?php endforeach; ?>
                </div>
            <!-- if文の最後を示す(；を使う構文の場合) -->
            <?php endif;?>
        </div>
    </div>
<?php include_once('../Views/common/foot.php'); ?>
    <!-- 練習エリア -->

</body>
</html>