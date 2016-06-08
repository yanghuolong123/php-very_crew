<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_advertisement".
 *
 * @property integer $id
 * @property string $name
 * @property string $position
 * @property string $url
 * @property integer $sort
 * @property integer $status
 * @property integer $createtime
 */
class TblAdvertisement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_advertisement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'position', 'url', 'sort', 'status', 'createtime'], 'required'],
            [['sort', 'status', 'createtime'], 'integer'],
            [['name', 'position', 'url'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'position' => '位置',
            'url' => '地址',
            'sort' => '排序',
            'status' => '状态',
            'createtime' => '创建时间',
        ];
    }
}
