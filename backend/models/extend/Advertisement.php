<?php

namespace app\models\extend;

class Advertisement extends \app\models\native\TblAdvertisement {

    public function rules() {
        return [
            [['name', 'position', 'url', 'sort', 'status'], 'required'],
            [['sort', 'status', 'createtime'], 'integer'],
            [['name', 'position', 'url'], 'string', 'max' => 128],
            [['link'], 'string', 'max' => 255],
        ];
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            //$this->status = 1;
            $this->createtime = time();
        }

        return parent::beforeSave($insert);
    }

    public static function getPostionArr($isArr = true, $pos = '') {
        $arr = [
            'banner' => 'banner',
        ];

        return $isArr ? $arr : (isset($arr[$pos]) ? $arr[$pos] : '');
    }

    public static function getStatusArr($isArr = true, $status = 0) {
        $arr = [
            0 => '启用',
            -1 => '禁用',
        ];

        return $isArr ? $arr : (isset($arr[$status]) ? $arr[$status] : '');
    }

}
