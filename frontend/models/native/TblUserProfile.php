<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_user_profile".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $gender
 * @property string $birthday
 * @property string $weixin
 * @property string $qq
 * @property string $height
 * @property string $weight
 * @property integer $province
 * @property integer $city
 * @property integer $county
 * @property integer $country
 * @property string $good_at_job
 * @property string $speciality
 * @property string $usingtime
 * @property string $remark
 */
class TblUserProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'gender', 'birthday', 'weixin', 'qq', 'height', 'weight', 'province', 'city', 'county', 'country', 'good_at_job', 'speciality', 'usingtime', 'remark'], 'required'],
            [['uid', 'gender', 'province', 'city', 'county', 'country'], 'integer'],
            [['birthday', 'weixin', 'qq'], 'string', 'max' => 65],
            [['height', 'weight'], 'string', 'max' => 25],
            [['good_at_job', 'speciality', 'usingtime'], 'string', 'max' => 128],
            [['remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增id',
            'uid' => '用户id',
            'gender' => '性别',
            'birthday' => '生日',
            'weixin' => '微信',
            'qq' => 'qq',
            'height' => '身高',
            'weight' => '体重',
            'province' => '省',
            'city' => '市',
            'county' => '县',
            'country' => '乡',
            'good_at_job' => '擅长职位',
            'speciality' => '表演特长',
            'usingtime' => '可用时间',
            'remark' => '其他说明',
        ];
    }
}
