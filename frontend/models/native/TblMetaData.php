<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_meta_data".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $group_key
 * @property string $key
 * @property string $value
 * @property integer $sort
 * @property integer $status
 */
class TblMetaData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_meta_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'group_key', 'key', 'value', 'sort', 'status'], 'required'],
            [['parent_id', 'sort', 'status'], 'integer'],
            [['group_key'], 'string', 'max' => 64],
            [['key'], 'string', 'max' => 65],
            [['value'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => '父ID',
            'group_key' => '分组KEY',
            'key' => 'KEY',
            'value' => 'VALUE',
            'sort' => '排序',
            'status' => '状态',
        ];
    }
}
