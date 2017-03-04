<?php

namespace app\models\extend;

use yii\helpers\ArrayHelper;

class ForumForum extends \app\models\native\TblForumForum {

    public static function getForumArrayList() {
        $data = self::findAll(['status' => 0]);

        return ArrayHelper::map(ArrayHelper::toArray($data), 'id', 'name');
    }

}
