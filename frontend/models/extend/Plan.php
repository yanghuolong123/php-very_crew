<?php

namespace app\models\extend;

use Yii;
use yii\helpers\ArrayHelper;

class Plan extends \app\models\native\TblPlan {

    public function rules() {
        return [
            [['title', 'content', 'type', 'tag', 'province', 'city', 'county', 'address', 'plan_role', 'plan_skill', 'begin_time', 'end_time',], 'required'],
            [['content'], 'string'],
            [['type', 'status', 'createtime'], 'integer'],
            [['title', 'address', 'remark'], 'string', 'max' => 255],
            [['tag', 'plan_role', 'plan_skill'], 'string', 'max' => 128],
            ['end_time', 'compare', 'compareAttribute'=>'begin_time', 'operator'=>'>', 'message'=>'结束时间需大于开始时间'],
        ];
    }

    public function beforeSave($insert) {
        if ($this->getIsNewRecord()) {
            $this->status = 1;
            $this->uid = Yii::$app->user->id;
            $this->createtime = time();
        }

        return parent::beforeSave($insert);
    }

    public function beforeValidate() {
        $this->tag = is_array($this->tag) ? ',' . implode(',', $this->tag) . ',' : $this->tag;
        $this->plan_role = is_array($this->plan_role) ? ',' . implode(',', $this->plan_role) . ',' : $this->plan_role;
        $this->plan_skill = is_array($this->plan_skill) ? ',' . implode(',', $this->plan_skill) . ',' : $this->plan_skill;
        $this->begin_time = strtotime($this->begin_time);
        $this->end_time = strtotime($this->end_time);
        
        return parent::beforeValidate();
    }

    public static function getPlanList($uid) {
        $data = static::find()->where(['uid' => $uid, 'status' => 1])->orderBy('id desc')->all();

        return ArrayHelper::map(ArrayHelper::toArray($data), 'id', 'title');
    }

}
