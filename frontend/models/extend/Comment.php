<?php

namespace app\models\extend;

use Yii;

class Comment extends \app\models\native\TblComment {

    public function rules() {
        return [
            [['uid', 'type', 'content'], 'required'],
            [['uid', 'type', 'vid', 'parent_id', 'status', 'createtime'], 'integer'],
            [['content'], 'string', 'max' => 255],
        ];
    }

    public function beforeSave($insert) {
        $this->status = empty($this->status) ? 1 : $this->status;
        $this->createtime = time();

        return parent::beforeSave($insert);
    }

    public static function getChildren($id) {
        return self::find()->where(['parent_id' => $id, 'status' => 1])->orderBy('id desc')->all();
    }

    public static function sendNews($toUid, $content) {
        $comment = new self();
        $comment->type = 4;
        $comment->uid = Yii::$app->user->id;
        $comment->vid = $toUid;
        $comment->content = $content;
        $comment->save();

        Yii::$app->redis->incr('user_news_' . $toUid);
    }

    public static function getTypeArr($returnArr = true, $type = 1) {
        $arr = [
            1 => '评论',
            2 => '留言',
            3 => '私信',
            4 => '消息',
        ];

        return $returnArr ? $arr : (isset($arr[$type]) ? $arr[$type] : '');
    }

}
