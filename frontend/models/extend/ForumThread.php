<?php

namespace app\models\extend;

use Yii;

class ForumThread extends \app\models\native\TblForumThread {

    public function rules() {
        return [
            [['fid', 'title', 'content'], 'required'],
            [['fid', 'user_id', 'views', 'posts', 'recommand', 'recommand_time', 'status', 'lastpost', 'createtime', 'updatetime'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 128],
            [['lastposter'], 'string', 'max' => 65],
        ];
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->createtime = $this->updatetime = TIMESTAMP;
            $this->user_id = Yii::$app->user->id;
        } else {
            $this->updatetime = TIMESTAMP;
        }

        return parent::beforeSave($insert);
    }

}
