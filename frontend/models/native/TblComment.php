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
 * @property integer $parent_id
 * @property string $content
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
            [['type', 'uid', 'vid', 'parent_id', 'content', 'status', 'createtime'], 'required'],
            [['type', 'uid', 'vid', 'parent_id', 'status', 'createtime'], 'integer'],
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
            'type' => '类型',
            'uid' => '用户id',
            'vid' => '对象id',
            'parent_id' => '父级id',
            'content' => '内容',
            'status' => '状态',
            'createtime' => '创建时间',
        ];
    }
}
