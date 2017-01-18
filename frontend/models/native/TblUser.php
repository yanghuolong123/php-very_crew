<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $nickname
 * @property string $mobile
 * @property string $email
 * @property string $avatar
 * @property string $thumb_avatar
 * @property integer $status
 * @property integer $createtime
 */
class TblUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'nickname', 'mobile', 'email', 'avatar', 'thumb_avatar', 'status', 'createtime'], 'required'],
            [['status', 'createtime'], 'integer'],
            [['username', 'nickname', 'mobile'], 'string', 'max' => 32],
            [['password', 'email'], 'string', 'max' => 65],
            [['avatar', 'thumb_avatar'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增id',
            'username' => '用户名(邮箱/手机号)',
            'password' => '密码',
            'nickname' => '姓名',
            'mobile' => '电话',
            'email' => '邮箱',
            'avatar' => '头像',
            'thumb_avatar' => '缩略图',
            'status' => '状态',
            'createtime' => '注册时间',
        ];
    }
}
