<?php

namespace app\models\extend;

class GamePrize extends \app\models\native\TblGamePrize {

    public function rules() {
        return [
            [['name', 'win_ids'], 'required'],
            [['game_id', 'sort', 'status', 'create_time'], 'integer'],
            [['name', 'win_ids'], 'string', 'max' => 128],
            [['instruction'], 'string', 'max' => 255],
        ];
    }

    public function beforeSave($insert) {
        $this->create_time = TIMESTAMP;

        return parent::beforeSave($insert);
    }

}
