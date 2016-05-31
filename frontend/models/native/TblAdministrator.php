<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_administrator".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 */
class TblAdministrator extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_administrator';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username'], 'string', 'max' => 65],
            [['password'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增id',
            'username' => '用户名',
            'password' => '密码',
        ];
    }
}
