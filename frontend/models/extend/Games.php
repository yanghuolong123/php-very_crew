<?php

namespace app\models\extend;

class Games extends \app\models\native\TblGames {

    public static function getStatusArr($isArr = true, $status = 0) {
        $arr = [
            1 => '报名进行中',
            0 => '报名已截止',
        ];

        return $isArr ? $arr : (isset($arr[$status]) ? $arr[$status] : '');
    }

}
