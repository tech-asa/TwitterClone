<?php
// エラー表示あり
ini_set('display_errors',1);
// 日本時間にする
date_default_timezone_get('Asia/Tokyo');
// URL/ディレクトリ設定
define('HOME_URL','/TwitterClone/');

// ツイート一覧
// 配列を入れる（関数$の中に[]で配列を入れる）
$view_tweeets = [
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
    ],
];

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../Views/img/logo-twitterblue.svg">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="../Views/css/style.css" rel="stylesheet">
    
    <title>ホーム画面 / Twitterクローン</title>
    <meta name="description" content="ホーム画面です">
</head>
<body class="home">
    <div class="container">
        <div class="side">
            <div class="side-inner">
                <ul class="nav flex-column">
                <li class="nav-item"><a href="home.php" class="nav-link"><img src="../Views/img/logo-twitterblue.svg" alt="" class="icon"></a></li>
                <li class="nav-item"><a href="home.php" class="nav-link"><img src="../Views/img/icon-home.svg" alt=""></a></li>
                <li class="nav-item"><a href="search.php" class="nav-link"><img src="../Views/img/icon-search.svg" alt=""></a></li>
                <li class="nav-item"><a href="notification.php" class="nav-link"><img src="../Views/img/icon-notification.svg" alt=""></a></li>
                <li class="nav-item"><a href="profile.php" class="nav-link"><img src="../Views/img/icon-profile.svg" alt=""></a></li>
                <li class="nav-item"><a href="post.php" class="nav-link"><img src="../Views/img/icon-post-tweet-twitterblue.svg" alt="" class="post-tweet"></a></li>
                <li class="nav-item my-icon"><img src="../Views/img_uploaded/user/sample-person.jpg" alt=""></li>
                </ul>
            </div>
        </div>
        <!-- メインの全体 -->
        <div class="main">
            <!-- メインのヘッダー -->
            <div class="main-header">
                <h1 class="">ホーム</h1>
            </div>
            
            <!-- つぶやき投稿エリア -->
            <div class="tweet-post">
                <div class="my-icon">
                    <img src="../Views/img_uploaded/user/sample-person.jpg" alt="">
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
            <div class="tweet-list">
                <div class="tweet">
                    <div class="user">
                        <a href="profile.php?user_id=1">
                            <img src="../Views/img_uploaded/user/sample-person.jpg" alt="">
                        </a>
                    </div>
                    <div class="content">
                        <div class="name">
                            <a href="profile.php?user_id=1">
                                <span class="nickname">太郎</span>
                                <span class="user-name">@taro・２３日前</span>
                            </a>
                        </div>
                        <p>今プログラミングをしています。</p>
                        <div class="icon-list">
                            <div class="like">
                                <img src="../Views/img/icon-heart.svg" alt="">
                            </div>
                            <div class="like-count">0</div>
                        </div>
                    </div>
                </div>

                <div class="tweet">
                    <div class="user">
                        <a href="profile.php?user_id=2">
                            <img src="../Views/img/icon-default-user.svg" alt="">
                        </a>
                    </div>
                    <div class="content">
                        <div class="name">
                            <a href="profile.php?user_id=2">
                                <span class="nickname">次郎</span>
                                <span class="user-name">@jiro・２４日前</span>
                            </a>
                        </div>
                        <p>コワーキングスペースをオープンしました。</p>
                        <img src="../Views/img_uploaded/tweet/sample-post.jpg" alt="" class="post-image">
                        <div class="icon-list">
                            <div class="like">
                                <img src="../Views/img/icon-heart-twitterblue.svg" alt="">
                            </div>
                            <div class="like-count">1</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>