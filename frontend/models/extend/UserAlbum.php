<?php

namespace app\models\extend;

use Yii;

class UserAlbum extends \app\models\native\TblUserAlbum {

    public function rules() {
        return [
            [['url'], 'required'],
            [['uid', 'status', 'createtime'], 'integer'],
            [['title', 'url'], 'string', 'max' => 128],
            [['desc'], 'string', 'max' => 255],
        ];
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->uid = Yii::$app->user->id;
            $this->createtime = time();
        }

        return parent::beforeSave($insert);
    }

}
