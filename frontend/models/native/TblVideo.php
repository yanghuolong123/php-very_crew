<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_video".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $plan_id
 * @property string $title
 * @property string $content
 * @property string $logo
 * @property string $file
 * @property integer $type
 * @property string $tag
 * @property integer $views
 * @property integer $comments
 * @property integer $support
 * @property integer $oppose
 * @property integer $status
 * @property integer $createtime
 */
class TblVideo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'plan_id', 'title', 'content', 'logo', 'file', 'type', 'tag', 'views', 'comments', 'support', 'oppose', 'status', 'createtime'], 'required'],
            [['uid', 'plan_id', 'type', 'views', 'comments', 'support', 'oppose', 'status', 'createtime'], 'integer'],
            [['content'], 'string'],
            [['title', 'logo', 'file', 'tag'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '用户ID',
            'plan_id' => '所属计划',
            'title' => '视频名称',
            'content' => '剧情介绍',
            'logo' => '作品封面',
            'file' => '视频文件',
            'type' => '视频类型',
            'tag' => '标签',
            'views' => '浏览数',
            'comments' => '评论数',
            'support' => '支持',
            'oppose' => '反对',
            'status' => '状态',
            'createtime' => '创建时间',
        ];
    }
}
