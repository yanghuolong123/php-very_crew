<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_forum_forum".
 *
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property integer $threads
 * @property integer $sort
 * @property integer $status
 * @property integer $createtime
 * @property integer $updatetime
 */
class TblForumForum extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_forum_forum';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'desc', 'threads', 'sort', 'status', 'createtime', 'updatetime'], 'required'],
            [['threads', 'sort', 'status', 'createtime', 'updatetime'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'desc' => '描述',
            'threads' => '帖子数',
            'sort' => '排序',
            'status' => '状态',
            'createtime' => '创建时间',
            'updatetime' => '修改时间',
        ];
    }
}
