///////////////////////////////////////
// いいね！用のJavaScript
/////////////////////////////////////// 

$(function () {
    // いいね！がクリックされたとき
    $('.js-like').click(function () { /* HTML内の「.js-like」が割り当てられているところをクリックすると以下の処理を行う */
        const this_obj = $(this); /* this=.js-likeがあるタグ内（？） */
        const tweet_id = $(this).data('tweet-id');
        const like_id = $(this).data('like-id');
        const like_count_obj = $(this).parent().find('.js-like-count'); /* thisの親要素内にある「.js-like-count」を見つける */
        let like_count = Number(like_count_obj.html()); /* 「like_count_obj」に入った数字を「整数」に直す */
 
        if (like_id) { /* もし「like_id」があるのであれば */
            // いいね！取り消し
            // 非同期通信
            $.ajax({
                url: 'like.php',
                type: 'POST',
                data:{
                    'like_id':like_id
                },
                timeout: 10000
            })
                // 取り消しが成功
                .done(()=>{
                // いいね！カウントを減らす
                like_count--;
                like_count_obj.html(like_count); /* huml内の「like_count」に代入する */
                this_obj.data('like-id', null); /* 「.data(like-id)」をnullにする */
 
                // いいね！ボタンの色をグレーに変更
                $(this).find('img').attr('src', '../Views/img/icon-heart.svg'); /* タグ内の「img」を見つけて「src」を変更する */
                })
                .fail((data)=>{
                    alert('処理中にエラーが発生しました。');
                    console.log(data);
                });
        } else {
            // いいね！付与       
            // 非同期通信 vue.js axios.js 
            $.ajax({
                url: 'like.php',
                type: 'POST',
                data:{
                    'tweet_id':tweet_id
                },
                timeout: 10000
            })
                // いいね！が成功
                .done((data)=>{
                    // いいね！カウントを増やす
                    like_count++;
                    like_count_obj.html(like_count);
                    this_obj.data('like-id', data['like_id']);
                    // いいね！ボタンの色を青に変更
                    $(this).find('img').attr('src', '../Views/img/icon-heart-twitterblue.svg');
                })
                .fail((data)=>{
                    alert('処理中にエラーが出ました。');
                    console.log(data);
                });
        }
    });
})