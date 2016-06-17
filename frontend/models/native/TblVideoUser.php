<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_video_user".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $video_id
 * @property integer $role
 * @property integer $is_star
 * @property integer $status
 * @property string $desc
 * @property integer $createtime
 */
class TblVideoUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_video_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'video_id', 'role', 'is_star', 'status', 'desc', 'createtime'], 'required'],
            [['uid', 'video_id', 'role', 'is_star', 'status', 'createtime'], 'integer'],
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
            'uid' => '加入人员',
            'video_id' => '视频id',
            'role' => '角色',
            'is_star' => '是否为主演',
            'status' => '状态',
            'desc' => '申请说明',
            'createtime' => '加入时间',
        ];
    }
}
