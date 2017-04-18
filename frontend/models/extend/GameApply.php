<?php

namespace app\models\extend;

class GameApply extends \app\models\native\TblGameApply {

    public function rules() {
        return [
            [['user_id', 'game_id', 'username', 'amount', 'summary', 'join_num', 'len_minute', 'len_second', 'condition', 'ability', 'advantage'], 'required'],
            [['user_id', 'game_id', 'amount', 'join_num', 'len_minute', 'len_second', 'status', 'create_time'], 'integer'],
            [['username'], 'string', 'max' => 65],
            [['summary', 'condition', 'ability', 'advantage'], 'string', 'max' => 255],
        ];
    }
    
    public function beforeSave($insert) {
        $this->create_time = TIMESTAMP;
        
        return parent::beforeSave($insert);
    }

    public static function getAmountList() {
        return [
            100 => '100',
            200 => '200',
            500 => '500',
        ];
    }

}
