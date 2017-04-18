<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_game_prize".
 *
 * @property integer $id
 * @property integer $game_id
 * @property string $name
 * @property string $desc
 * @property string $win_ids
 * @property integer $status
 * @property integer $create_time
 */
class TblGamePrize extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_game_prize';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id', 'name', 'desc', 'win_ids', 'status', 'create_time'], 'required'],
            [['game_id', 'status', 'create_time'], 'integer'],
            [['name', 'win_ids'], 'string', 'max' => 128],
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
            'game_id' => '大赛id',
            'name' => '奖项名称',
            'desc' => '奖项描述',
            'win_ids' => '获奖作品id,用“，”分割',
            'status' => '状态',
            'create_time' => '创建时间',
        ];
    }
}
