<?php

namespace app\models\extend;

class Advertisement extends \app\models\native\TblAdvertisement {

    public function rules() {
        return [
            [['name', 'postion', 'url', 'sort', 'status'], 'required'],
            [['sort', 'status', 'createtime'], 'integer'],
            [['name', 'postion', 'url'], 'string', 'max' => 128],
        ];
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->status = 1;
            $this->createtime = time();
        }

        return parent::beforeSave($insert);
    }

}
