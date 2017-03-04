<?php

namespace app\models\extend;

class ForumThread extends \app\models\native\TblForumThread {

    public static function getRecommandArr($isArr = true, $recommand = 0) {
        $arr = [
            0 => '否',
            1 => '是',
        ];

        return $isArr ? $arr : (isset($arr[$recommand]) ? $arr[$recommand] : '');
    }

}
