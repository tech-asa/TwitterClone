<script>
    // 「addEventListener()」は、JavaScriptからさまざまなイベント処理を実行することができるメソッドになります。
    // 対象要素.addEventListener( 種類=どんな時(今回の場合はWebページが読み込みが完了した時に発動), 関数=どんな処理を, false )
    document.addEventListener('DOMContentLoaded',function(){
        $('.js-popover').popover(); //処理
    },false);
</script>
