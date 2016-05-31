<?php

namespace app\models\extend;

use Yii;

class UserProfile extends \app\models\native\TblUserProfile {

    public function rules() {
        return [
            [['gender', 'birthday', 'province', 'city', 'county', 'good_at_job', 'speciality', 'usingtime'], 'required'],
            [['id', 'uid', 'gender', 'province', 'city', 'county', 'country'], 'integer'],
            [['birthday', 'weixin', 'qq'], 'string', 'max' => 65],
            [['height', 'weight'], 'string', 'max' => 25],
            [['good_at_job', 'speciality', 'usingtime'], 'string', 'max' => 128],
            [['remark'], 'string', 'max' => 255],
        ];
    }

    public function beforeValidate() {
        $this->good_at_job = is_array($this->good_at_job) ? ',' . implode(',', $this->good_at_job) . ',' : $this->good_at_job;
        $this->speciality = is_array($this->speciality) ? ',' . implode(',', $this->speciality) . ',' : $this->speciality;
        $this->usingtime = is_array($this->usingtime) ? ',' . implode(',', $this->usingtime) . ',' : $this->usingtime;

        return parent::beforeValidate();
    }

}
