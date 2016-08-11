<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_plan".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $title
 * @property string $content
 * @property integer $type
 * @property string $tag
 * @property integer $province
 * @property integer $city
 * @property integer $county
 * @property integer $country
 * @property string $address
 * @property string $plan_role
 * @property string $plan_skill
 * @property string $remark
 * @property integer $status
 * @property integer $createtime
 */
class TblPlan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_plan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'title', 'content', 'type', 'tag', 'province', 'city', 'county', 'country', 'address', 'plan_role', 'plan_skill', 'remark', 'status', 'createtime'], 'required'],
            [['uid', 'type', 'province', 'city', 'county', 'country', 'status', 'createtime'], 'integer'],
            [['content'], 'string'],
            [['title', 'address', 'remark'], 'string', 'max' => 255],
            [['tag', 'plan_role', 'plan_skill'], 'string', 'max' => 128],
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
            'title' => '拍摄计划',
            'content' => '剧情说明',
            'type' => '拍摄类型',
            'tag' => '标签',
            'province' => '拍摄省份',
            'city' => '拍摄城市',
            'county' => '县',
            'country' => '乡',
            'address' => '具体地点',
            'plan_role' => '所需角色',
            'plan_skill' => '所需技能',
            'remark' => '备注信息',
            'status' => '状态',
            'createtime' => '创建时间',
        ];
    }
}
