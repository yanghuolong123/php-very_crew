<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_user_stat".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $login_time
 */
class TblUserStat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_user_stat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'login_time'], 'required'],
            [['id', 'uid', 'login_time'], 'integer'],
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
            'login_time' => '登陆次数',
        ];
    }
}
