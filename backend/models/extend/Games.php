<?php

namespace app\models\extend;

class Games extends \app\models\native\TblGames {

    public function rules() {
        return [
            [['type', 'name', 'logo', 'content', 'order', 'status', 'begin_time', 'end_time'], 'required'],
            [['type', 'order', 'status', 'number', 'create_time'], 'integer'],
            [['content'], 'string'],
            [['name', 'logo'], 'string', 'max' => 128],
        ];
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->begin_time = strtotime($this->begin_time);
            $this->end_time = strtotime($this->end_time);
            $this->create_time = time();
        }
        return parent::beforeSave($insert);
    }

}
