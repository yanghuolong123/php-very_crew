<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_district".
 *
 * @property integer $id
 * @property string $name
 * @property integer $level
 * @property integer $parent_id
 * @property integer $sort
 */
class TblDistrict extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_district';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'parent_id', 'sort'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '地区名称',
            'level' => '地区等级',
            'parent_id' => '上级地区ID',
            'sort' => '显示顺序',
        ];
    }
}
