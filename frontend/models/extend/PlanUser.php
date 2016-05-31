<?php

namespace app\models\extend;

use Yii;

class PlanUser extends \app\models\native\TblPlanUser {

    public function rules() {
        return [
            [['uid', 'plan_id', 'role', 'desc'], 'required'],
            [['uid', 'plan_id', 'role', 'status', 'createtime', 'updatetime'], 'integer'],
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
