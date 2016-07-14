<?php

namespace app\models\extend;

use Yii;
use app\models\extend\MetaData;

class PlanUser extends \app\models\native\TblPlanUser {

    public function rules() {
        return [
            [['uid', 'plan_id'], 'required'],
            [['uid', 'plan_id', 'role', 'status', 'createtime', 'updatetime'], 'integer'],
            [['desc'], 'string', 'max' => 255],
            [['role_name'], 'string', 'max' => 128],
            [['role'], 'default', 'value' => 0],
        ];
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->updatetime = $this->createtime = time();
        }

        return parent::beforeSave($insert);
    }

    public static function turnToVideoUser($planId, $videoId) {
        $models = self::findAll(['plan_id' => $planId, 'status' => 1]);

        foreach ($models as $model) {
            $videoUser = new \app\models\extend\VideoUser();
            $videoUser->uid = $model->uid;
            $videoUser->video_id = $videoId;
            $videoUser->role = $model->role;
            $videoUser->role_name = $model->role_name; // MetaData::getVal($model->role);
            $videoUser->status = 0;
            $videoUser->save(false);
        }
    }

}
