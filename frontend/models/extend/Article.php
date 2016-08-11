<?php

namespace app\models\extend;

class Article extends \app\models\native\TblArticle {

    public static function getByGroopKey($key) {
        return self::find()->where(['groop_key' => $key, 'status' => 0])->orderBy('sort asc')->all();
    }

}
