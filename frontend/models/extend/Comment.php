<?php

namespace app\models\extend;

class Comment extends \app\models\native\TblComment {

    public function rules() {
        return [
            [['uid', 'vid', 'content'], 'required'],
            [['uid', 'vid', 'parent_id', 'status', 'createtime'], 'integer'],
            [['content'], 'string', 'max' => 255],
        ];
    }

    public function beforeSave($insert) {
        $this->status = 1;
        $this->createtime = time();

        return parent::beforeSave($insert);
    }

    public static function getChildren($id) {
        return self::find()->where(['parent_id' => $id, 'status' => 1])->orderBy('id desc')->all();
    }

}
