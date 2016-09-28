<?php

namespace app\models\extend;

class Games extends \app\models\native\TblGames {

    public function rules() {
        return [
            [['name', 'logo', 'content', 'order', 'status', 'begin_time', 'end_time'], 'required'],
            [['type', 'order', 'status', 'number', 'create_time'], 'integer'],
            [['content'], 'string'],
            [['name', 'logo'], 'string', 'max' => 128],
            ['end_time', 'compare', 'compareAttribute' => 'begin_time', 'operator' => '>', 'message' => '结束时间需大于开始时间'],
        ];
    }

    public function beforeValidate() {
        $this->begin_time = strtotime($this->begin_time);
        $this->end_time = strtotime($this->end_time);

        return parent::beforeValidate();
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->create_time = time();
        }
        return parent::beforeSave($insert);
    }

    public static function getStatusArr($isArr = true, $status = 0) {
        $arr = [
            1 => '启用',
            0 => '禁用',
        ];

        return $isArr ? $arr : (isset($arr[$status]) ? $arr[$status] : '');
    }

}
