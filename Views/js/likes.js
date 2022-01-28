///////////////////////////////////////
// いいね！用のJavaScript
/////////////////////////////////////// 

$(function () {
    // いいね！がクリックされたとき
    $('.js-like').click(function () { /* HTML内の「.js-like」が割り当てられているところをクリックすると以下の処理を行う */
        const this_obj = $(this); /* this=.js-likeがあるタグ内（？） */
        const like_id = $(this).data('like-id');
        const like_count_obj = $(this).parent().find('.js-like-count'); /* thisの親要素内にある「.js-like-count」を見つける */
        let like_count = Number(like_count_obj.html()); /* 「like_count_obj」に入った数字を「整数」に直す */
 
        if (like_id) { /* もし「like_id」があるのであれば */
            // いいね！取り消し
            // いいね！カウントを減らす
            like_count--;
            like_count_obj.html(like_count); /* huml内の「like_count」に代入する */
            this_obj.data('like-id', null); /* 「.data(like-id)」をnullにする */
 
            // いいね！ボタンの色をグレーに変更
            $(this).find('img').attr('src', '../Views/img/icon-heart.svg'); /* タグ内の「img」を見つけて「src」を変更する */
        } else {
            // いいね！付与
            // いいね！カウントを増やす
            like_count++;
            like_count_obj.html(like_count);
            this_obj.data('like-id', true);
 
            // いいね！ボタンの色を青に変更
            $(this).find('img').attr('src', '../Views/img/icon-heart-twitterblue.svg');
        }
    });
})