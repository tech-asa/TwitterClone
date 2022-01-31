<?php
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