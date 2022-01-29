<?php
// エラー表示あり
ini_set('display_errors',1);
// 日本時間にする
date_default_timezone_set('Asia/Tokyo');
// URL/ディレクトリ設定
define('HOME_URL','/TwitterClone/');

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
    ],
];


// 便利な関数

/**
 * 画像ファイル名から画像のURLを生成する
 *
 * @param string $name 画像ファイル名
 * @param string $type user | tweet
 * @return string
 */
function buildImagePath(string $name = null,string $type) /* $nameが第一引数、$typeが第二引数 */
{
    if($type === 'user' && !isset($name)){  //ユーザー画像で、ファイル名がセットされていない場合
        return HOME_URL.'Views/img/icon-default-user.svg'; //この処理を行うことによって「buildImagePath」という文字列を入れるだけで左の値を返す
    }

    return HOME_URL.'Views/img_uploaded/'. $type .'/'. htmlspecialchars($name); //htmlspecialcharsは全てを文字列に変える(例えばコードを入力させない)
}

/**
 * 指定した日時からどれだけ経過したかを取得
 *
 * @param string $datetime 日時
 * @return string
 */

// UNIXタイムスタンプとは、協定世界時(UTC)での1970年1月1日0時0分0秒からの経過時間を秒数で表したもの
// strtotime(英文形式文字列 or日付/時刻 フォーマット文字列)

// 英文形式文字列使用例)
// strtotime("+1 day +1 week +1 month +1 year") → 本日から1年1ヶ月と1週間と1日加算してタイムスタンプを取得する
// 日付/時刻 フォーマット文字列使用例)
// strtotime("2020-01-02 03:04:05") →1970/1/1 0:0:0 ～ 2020/1/2 3:4:5までの経過秒数を取得する

// functionは関数 今回の場合は「convertToDayTimeAgo」を入れれば、下の{}内の処理が適用される
// stringは「文字列」が入っているかどうかチェックする関数
// intは文字列を表す

function convertToDayTimeAgo(string $datetime){ //datetimeはただの引数
    $unix = strtotime($datetime);   //データを受けた時間
    $now = time();                  //今現在
    $diff_sec = $now - $unix;

    if ($diff_sec <  60){   //1分未満の場合
        $time = $diff_sec;
        $unit = '秒前';
    } elseif($diff_sec < (60 * 60)){    //1時間未満の場
        $time = $diff_sec / 60;
        $unit = '分前';
    } elseif($diff_sec < (60 * 60 * 24)) {  //1日未満の場
        $time = $diff_sec / 3600;
        $unit = '時間前';
    } elseif($diff_sec < (60 * 60 * 24 * 32)) { //1ヶ月未満の場合
        $time = $diff_sec / 86400;
        $unit = '日前';
    } else {    //もし1ヶ月以降の場合

        if (date('Y') !== date('Y',$unix)) {    //もし同じ「年」じゃなければ
            $time = date('Y年n月j日',$unix);
        } else{ //もし同じ「年」であれば
            $time = date('n月j日',$unix);   
        }
        return $time;
    }

    return(int)$time.$unit;
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo HOME_URL; ?>Views/img/logo-twitterblue.svg">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="<?php echo HOME_URL; ?>Views/css/style.css" rel="stylesheet">
    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous" defer></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous" defer></script>
    <!-- いいね！JS -->
    <script src="<?php echo HOME_URL; ?>Views/js/likes.js" defer></script>
    <!-- 「src」とは「情報元」で参照元のファイルを選択してくる。
        特に深い意味はないので「とりあえずつけるんだ」という認識 -->

    <title>ホーム画面 / Twitterクローン</title>
    <meta name="description" content="ホーム画面です">
</head>
<body class="home">
    <div class="container">
        <div class="side">
            <div class="side-inner">
                <ul class="nav flex-column">
                <li class="nav-item"><a href="home.php" class="nav-link"><img src="<?php echo HOME_URL; ?>Views/img/logo-twitterblue.svg" alt="" class="icon"></a></li>
                <li class="nav-item"><a href="home.php" class="nav-link"><img src="<?php echo HOME_URL; ?>Views/img/icon-home.svg" alt=""></a></li>
                <li class="nav-item"><a href="search.php" class="nav-link"><img src="<?php echo HOME_URL; ?>Views/img/icon-search.svg" alt=""></a></li>
                <li class="nav-item"><a href="notification.php" class="nav-link"><img src="<?php echo HOME_URL; ?>Views/img/icon-notification.svg" alt=""></a></li>
                <li class="nav-item"><a href="profile.php" class="nav-link"><img src="<?php echo HOME_URL; ?>Views/img/icon-profile.svg" alt=""></a></li>
                <li class="nav-item"><a href="post.php" class="nav-link"><img src="<?php echo HOME_URL; ?>Views/img/icon-post-tweet-twitterblue.svg" alt="" class="post-tweet"></a></li>
                <li class="nav-item my-icon"><img src="<?php echo HOME_URL; ?>Views/img_uploaded/user/sample-person.jpg" alt="" 
                class="js-popover" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" 
                data-bs-html="true" data-bs-content="<a href='profile.php'>プロフィール</a><br><a href='sign-out.php'>ログアウト</a>"></li>
                <!-- ↑参照元https://getbootstrap.jp/docs/5.0/components/popovers/ -->
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
                        <div class="tweet">
                            <div class="user">
                            <a href="profile.php?user_id = <?php echo htmlspecialchars($view_tweet['user_id']); ?>">
                                    <img src="<?php echo buildImagePath($view_tweet['user_image_name'],'user'); ?>" alt="">
                                </a>
                            </div>
                            <div class="content">
                                <div class="name">
                                    <a href="profile.php?user_id=<?php echo htmlspecialchars($view_tweet['user_id']); ?>">
                                        <span class="nickname"><?php echo htmlspecialchars($view_tweet['user_nickname']); ?></span>
                                        <span class="user-name">@<?php echo htmlspecialchars($view_tweet['user_name']); ?>・<?php echo convertToDayTimeAgo($view_tweet['tweet_created_at']); ?></span>
                                    </a>
                                </div>
                                <p><?php echo $view_tweet['tweet_body']; ?></p>

                                <!-- isset関数は()の中に値が入っていた場合に真を返す値でNULLが入ってなければ基本的に真 -->
                                <?php if (isset($view_tweet['tweet_image_name'])) : ?>
                                    <img src="<?php echo buildImagePath($view_tweet['tweet_image_name'], 'tweet'); ?>" alt="" class="post-image">
                                <?php endif; ?>

                                <div class="icon-list">
                                    <div class="like js-like" data-like-id="<?php echo htmlspecialchars($view_tweet['like_id']); ?>">
                                        <?php
                                            if (isset($view_tweet['like_id'])) {
                                                // いいね！している場合、青のハートを表示
                                                echo '<img src="' . HOME_URL . 'Views/img/icon-heart-twitterblue.svg" alt="">';
                                            } else {
                                                // いいね！してない場合、グレーのハートを表示
                                                echo '<img src="' . HOME_URL . 'Views/img/icon-heart.svg" alt="">';
                                            }
                                        ?>                                    
                                    </div>
                                    <div class="like-count js-like-count"><?php echo htmlspecialchars($view_tweet['like_count']); ?></div>
                                </div>
                            </div>
                        </div>
                    <!-- foreach文の最後を示す -->    
                    <?php endforeach; ?>
                </div>
            <!-- if文の最後を示す(；を使う構文の場合) -->
            <?php endif;?>
        </div>
    </div>

    <!-- 練習エリア -->
    

    <script>
        // 「addEventListener()」は、JavaScriptからさまざまなイベント処理を実行することができるメソッドになります。
        // 対象要素.addEventListener( 種類=どんな時(今回の場合はWebページが読み込みが完了した時に発動), 関数=どんな処理を, false )
        document.addEventListener('DOMContentLoaded',function(){
            $('.js-popover').popover(); //処理
        },false);
    </script>

</body>
</html>