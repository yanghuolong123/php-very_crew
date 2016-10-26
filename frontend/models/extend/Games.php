<?php

namespace app\models\extend;

class Games extends \app\models\native\TblGames {

    public static function getStatusArr($isArr = true, $status = 0) {
        $arr = [
            0 => '作品上传进行中',
            1 => '投票进行中',
            2 => '大赛结果评比中',
            2 => '大赛已结束',
        ];

        return $isArr ? $arr : (isset($arr[$status]) ? $arr[$status] : '');
    }

}
