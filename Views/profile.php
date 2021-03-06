<!DOCTYPE html>
<html lang="ja">

<head>
    <?php include_once('../Views/common/head.php'); ?>
    <title>プロフィール画面 / Twitterクローン</title>
    <meta name="description" content="プロフィール画面です">
</head>

<body class="home profile text-center">
    <div class="container">
    <?php include_once('../Views/common/side.php'); ?>
        <!-- メインの全体 -->
        <div class="main">
            <!-- メインのヘッダー -->
            <div class="main-header">
                <h1><?php echo $view_requested_user['nickname']; ?></h1>
            </div>

            <!-- プロフィールエリア -->
            <div class="profile-area">
                <div class="top">
                    <div class="user"><img src="<?php echo buildImagePath($view_requested_user['image_name'],'user'); ?>" alt=""></div>

                    <?php if($view_user['id'] !== $view_requested_user['id']): ?>
                        <!-- 相手のページ -->
                        <?php if(isset($view_requested_user['follow_id'])):?>
                            <button class="btn btn-sm js-follow" data-followed-user-id="<?php echo $view_requested_user['id']; ?>" data-follow-id="<?php echo $view_requested_user['follow_id']; ?>">フォローを外す</button>
                        <?php else: ?>
                            <button class="btn btn-sm btn-reverse js-follow" data-followed-user-id="<?php echo $view_requested_user['id']; ?>">フォローする</button>
                        <?php endif; ?>
                    <?php else: ?>
                        <!-- 自分のページ -->
                        <!-- クリックされた時にモーダル機能で#js-modalが表示されるように -->
                        <button class="btn btn-reverse btn-sm" data-bs-toggle="modal" data-bs-target="#js-modal">プロフィール編集</button>                
                        <!-- フェードインしてモーダル表示 タブ操作の対象から外す 端末の読み上げ機能から外す-->
                        <div class="modal fade" id="js-modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="profile.php" method="post" enctype="multipart/form-data">
                                        <div class="modal-header">
                                            <h5 class="modal-title">プロフィール編集</h5>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="user">
                                                <img src="<?php echo buildImagePath($view_user['image_name'],'user');?>" alt="">
                                            </div>
                                            <div class="mb-3">
                                                <label for="" class="mb-1">プロフィール写真</label>
                                                <input type="file" class="form-control form-control-sm" name="image">
                                            </div>

                                            <input type="text" class="form-control mb-4" name="nickname" value="<?php echo htmlspecialchars($view_user['nickname']); ?>" placeholder="ニックネーム" maxlength="50" required>
                                            <input type="text" class="form-control mb-4" name="name" value="<?php echo htmlspecialchars($view_user['name']); ?>" placeholder="ユーザー名、例）techis132" maxlength="50" required>
                                            <input type="email" class="form-control mb-4" name="email" value="<?php echo htmlspecialchars($view_user['email']); ?>" placeholder="メールアドレス" maxlength="254" required>
                                            <input type="password" class="form-control mb-4" name="password" value="" placeholder="パスワードを変更する場合にご入力ください" minlength="4" maxlength="128">
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-reverse" data-bs-dismiss="modal">キャンセル</button>
                                            <button class="btn" type="submit">保存する</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="name"><?php echo htmlspecialchars($view_requested_user['nickname']); ?></div>
                <div class="text-muted">@<?php echo htmlspecialchars($view_requested_user['name']); ?></div>

                <div class="follow-follower">
                    <div class="follow-count"><?php echo htmlspecialchars($view_requested_user['follow_user_count']); ?></div>
                    <div class="follow-text">フォロー中</div>
                    <div class="follow-count"><?php echo htmlspecialchars($view_requested_user['followed_user_count']); ?></div>
                    <div class="follow-text">フォロワー</div>
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
            <?php else: ?>
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
</body>

</html>