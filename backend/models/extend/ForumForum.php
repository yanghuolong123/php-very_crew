<?php

namespace app\models\extend;

class ForumForum extends \app\models\native\TblForumForum {

    public function rules() {
        return [
            [['name', 'sort', 'status'], 'required'],
            [['sort', 'status', 'createtime', 'updatetime'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['instruction'], 'string', 'max' => 255],
        ];
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->createtime = $this->updatetime = time();
        } else {
            $this->updatetime = time();
        }

        return parent::beforeSave($insert);
    }

    public static function getStatusArr($isArr = true, $status = 0) {
        $arr = [
            0 => '启用',
            -1 => '禁用',
        ];

        return $isArr ? $arr : (isset($arr[$status]) ? $arr[$status] : '');
    }

}
