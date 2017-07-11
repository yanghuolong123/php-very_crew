<?php

namespace app\models\extend;

use Yii;
use yii\helpers\ArrayHelper;
use app\util\Constant;

class Video extends \app\models\native\TblVideo {

    public $oldFile;

    public function rules() {
        return [
            [['title', 'content', 'logo', 'file', 'type', 'tag'], 'required'],
            [['type', 'province', 'city', 'county', 'country'], 'integer'],
            [['content'], 'string'],
            [['title', 'logo', 'thumb_logo', 'tag', 'file'], 'string', 'max' => 128],
            [['plan_id', 'province', 'city', 'county', 'country'], 'default', 'value' => 0],
            [['remark'], 'string', 'max' => 255],
            [['duration'], 'string', 'max' => 60],
        ];
    }

    public function beforeSave($insert) {
        if ($this->getIsNewRecord()) {
            //$this->status = 1;
            $this->uid = Yii::$app->user->id;
            $this->createtime = time();
        } else {
            if (!empty($this->oldFile) && $this->oldFile != $this->file && $this->status == 1) {
                $this->status = 0;
            }
        }


        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes) {
        if (empty($this->oldFile) || (!empty($this->oldFile) && $this->oldFile != $this->file)) {
            Yii::$app->redis->LPUSH(Constant::ConvertVideoList, $this->id);
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

    public function afterFind() {
        $this->oldFile = $this->file;
        parent::afterFind();
    }

    public static function getVideoList($uid) {
        $data = static::find()->where(['uid' => $uid, 'status' => 1])->orderBy('id desc')->all();

        return ArrayHelper::map(ArrayHelper::toArray($data), 'id', 'title');
    }

    public static function getIdsBySearchName($name) {
        return static::find()->select(['id'])->andFilterWhere(['like', 'title', $name])->createCommand()->queryColumn();
    }

}
