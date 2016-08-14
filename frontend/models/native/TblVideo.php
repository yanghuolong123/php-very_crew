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
 * @property string $thumb_logo
 * @property string $file
 * @property integer $type
 * @property integer $province
 * @property integer $city
 * @property integer $county
 * @property integer $country
 * @property string $tag
 * @property integer $views
 * @property integer $comments
 * @property integer $support
 * @property integer $oppose
 * @property string $remark
 * @property integer $status
 * @property string $duration
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
            [['uid', 'plan_id', 'title', 'content', 'logo', 'thumb_logo', 'file', 'type', 'province', 'city', 'county', 'country', 'tag', 'views', 'comments', 'support', 'oppose', 'remark', 'status', 'duration', 'createtime'], 'required'],
            [['uid', 'plan_id', 'type', 'province', 'city', 'county', 'country', 'views', 'comments', 'support', 'oppose', 'status', 'createtime'], 'integer'],
            [['content'], 'string'],
            [['title', 'logo', 'thumb_logo', 'file', 'tag'], 'string', 'max' => 128],
            [['remark'], 'string', 'max' => 255],
            [['duration'], 'string', 'max' => 60],
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
            'thumb_logo' => '缩略图',
            'file' => '视频文件',
            'type' => '视频类型',
            'province' => '省',
            'city' => '市',
            'county' => '县',
            'country' => '乡',
            'tag' => '标签',
            'views' => '浏览数',
            'comments' => '评论数',
            'support' => '支持',
            'oppose' => '反对',
            'remark' => '备注说明',
            'status' => '状态',
            'duration' => '视频时常',
            'createtime' => '创建时间',
        ];
    }
}
