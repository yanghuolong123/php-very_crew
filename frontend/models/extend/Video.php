<?php

namespace app\models\extend;

use Yii;
use yii\helpers\ArrayHelper;

class Video extends \app\models\native\TblVideo {

    public function rules() {
        return [
            [['title', 'content', 'logo', 'file', 'type', 'tag'], 'required'],
            [['type', 'province', 'city', 'county', 'country'], 'integer'],
            [['content'], 'string'],
            [['title', 'logo', 'thumb_logo', 'tag', 'file'], 'string', 'max' => 128],
            [['plan_id'], 'default', 'value' => 0],
        ];
    }

    public function beforeSave($insert) {
        if ($this->getIsNewRecord()) {
            $this->status = 1;
            $this->uid = Yii::$app->user->id;
            $this->createtime = time();
        }

        if (strtolower(pathinfo($this->file)['extension']) != "mp4") {
            $this->status = 0;
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes) {
        if (strtolower(pathinfo($this->file)['extension']) != "mp4") {
            Yii::$app->redis->LPUSH("convert_video_list", $this->id);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeValidate() {
//        if ($this->logo == './image/blank_img.jpg') {
//            $this->logo = '';
//        }
        $this->tag = is_array($this->tag) ? ',' . implode(',', $this->tag) . ',' : $this->tag;

        return parent::beforeValidate();
    }

    public static function getVideoList($uid) {
        $data = static::find()->where(['uid' => $uid, 'status' => 1])->orderBy('id desc')->all();

        return ArrayHelper::map(ArrayHelper::toArray($data), 'id', 'title');
    }

}
