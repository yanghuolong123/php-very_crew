<?php

namespace app\models\extend;

class Article extends \app\models\native\TblArticle {

    public function rules() {
        return [
            [['groop_key', 'title', 'content'], 'required'],
            [['content'], 'string'],
            [['sort', 'status', 'createtime'], 'integer'],
            [['groop_key'], 'string', 'max' => 65],
            [['title'], 'string', 'max' => 128],
            [['sort'], 'default', 'value'=>0],
        ];
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->createtime = time();
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

    public static function getGroopKeyArr($isArr = true, $key = '') {
        $arr = [
            'footer_nav' => '底部导航',
        ];

        return $isArr ? $arr : (isset($arr[$key]) ? $arr[$key] : '');
    }

}
