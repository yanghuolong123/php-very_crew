<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_comment".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $uid
 * @property integer $vid
 * @property integer $reply_id
 * @property integer $parent_id
 * @property string $content
 * @property integer $support
 * @property integer $oppose
 * @property integer $status
 * @property integer $createtime
 */
class TblComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'uid', 'vid', 'reply_id', 'parent_id', 'content', 'support', 'oppose', 'status', 'createtime'], 'required'],
            [['type', 'uid', 'vid', 'reply_id', 'parent_id', 'support', 'oppose', 'status', 'createtime'], 'integer'],
            [['content'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '类型:1评论，2留言，3私信，4消息',
            'uid' => '用户id',
            'vid' => '对象id',
            'reply_id' => '回复人uid',
            'parent_id' => '父级id',
            'content' => '内容',
            'support' => '顶',
            'oppose' => '踩',
            'status' => '状态',
            'createtime' => '创建时间',
        ];
    }
}
