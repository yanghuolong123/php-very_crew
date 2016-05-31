<?php

namespace app\models\extend;

use yii\helpers\ArrayHelper;

class MetaData extends \app\models\native\TblMetaData {

    public static function getGroupList($groupKey) {
        $data = static::findByCondition(['group_key' => $groupKey, 'status' => 1])->orderBy('sort asc')->all();

        return ArrayHelper::map(ArrayHelper::toArray($data), 'id', 'value');
    }

    public static function getVal($id) {
        $data = static::findOne(['id' => $id]);

        return empty($data) ? '' : $data->value;
    }

    public static function getArrVal($ids = []) {
        $data = static::findAll(['id' => $ids]);

        return ArrayHelper::map(ArrayHelper::toArray($data), 'id', 'value');
    }

}
