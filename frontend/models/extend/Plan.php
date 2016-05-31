<?php

namespace app\models\extend;

use Yii;

class Plan extends \app\models\native\TblPlan {

    public function rules() {
        return [
            [['title', 'content', 'type', 'tag', 'province', 'city', 'county', 'address', 'plan_role', 'plan_skill'], 'required'],
            [['content'], 'string'],
            [['type', 'status', 'createtime'], 'integer'],
            [['title', 'address', 'remark'], 'string', 'max' => 255],
            [['tag', 'plan_role', 'plan_skill', 'video_ids'], 'string', 'max' => 128],
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
        $this->video_ids = is_array($this->video_ids) ? ',' . implode(',', $this->video_ids) . ',' : $this->video_ids;

        return parent::beforeValidate();
    }

}
