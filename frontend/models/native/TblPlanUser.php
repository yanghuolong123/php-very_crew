<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_plan_user".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $uid
 * @property integer $plan_id
 * @property integer $role
 * @property integer $status
 * @property string $desc
 * @property integer $createtime
 * @property integer $updatetime
 */
class TblPlanUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_plan_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'uid', 'plan_id', 'role', 'status', 'desc', 'createtime', 'updatetime'], 'required'],
            [['type', 'uid', 'plan_id', 'role', 'status', 'createtime', 'updatetime'], 'integer'],
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
            'type' => '类型',
            'uid' => '用户ID',
            'plan_id' => '计划',
            'role' => '申请角色',
            'status' => '状态',
            'desc' => '申请说明',
            'createtime' => '申请时间',
            'updatetime' => '审核时间',
        ];
    }
}
