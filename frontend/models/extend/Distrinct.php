<?php

namespace app\models\extend;

use yii\helpers\ArrayHelper;

class Distrinct extends \app\models\native\TblDistrict {

    public static function getDistrictList($pid) {
        $data = self::find()->where(['parent_id' => $pid])->orderBy('sort asc')->all();

        return ArrayHelper::map(ArrayHelper::toArray($data), 'id', 'name');
    }
    
    public static function getArrDistrict($ids=[]) {
        $data = static::findAll(['id'=>$ids]);
        
        return ArrayHelper::map(ArrayHelper::toArray($data), 'id', 'name');
    }

}
