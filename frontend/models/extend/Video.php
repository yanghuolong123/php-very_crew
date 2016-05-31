<?php

namespace app\models\extend;

use Yii;
use yii\helpers\ArrayHelper;

class Video extends \app\models\native\TblVideo {

    public function rules() {
        return [
            [['title', 'content', 'logo', 'file', 'type', 'tag'], 'required'],
            [['type'], 'integer'],
            [['content'], 'string'],
            [['title', 'logo', 'tag', 'file'], 'string', 'max' => 128],
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

        return parent::beforeValidate();
    }

    public static function getVideoList($uid) {
        $data = static::find()->where(['uid' => $uid, 'status' => 1])->orderBy('id desc')->all();

        return ArrayHelper::map(ArrayHelper::toArray($data), 'id', 'title');
    }

}
