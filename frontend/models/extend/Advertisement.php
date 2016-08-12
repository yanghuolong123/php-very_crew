<?php

namespace app\models\extend;

class Advertisement extends \app\models\native\TblAdvertisement {

    public static function getAdByPos($pos) {
        return self::find()->where(['status' => 0, 'position' => $pos])->orderBy('sort asc')->all();
    }

}
