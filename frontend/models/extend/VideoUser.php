<?php

namespace app\models\extend;

class VideoUser extends \app\models\native\TblVideoUser {

    public function rules() {
        return [
            [['uid', 'video_id', 'role', 'is_star'], 'required'],
            [['uid', 'video_id', 'role', 'is_star', 'status', 'createtime'], 'integer'],
            [['desc'], 'string', 'max' => 255],
        ];
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->createtime = time();
        }

        return parent::beforeSave($insert);
    }

}
