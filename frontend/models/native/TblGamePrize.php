<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_game_prize".
 *
 * @property integer $id
 * @property integer $game_id
 * @property string $name
 * @property string $instruction
 * @property string $win_ids
 * @property integer $sort
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
            [['game_id', 'name', 'instruction', 'win_ids', 'sort', 'status', 'create_time'], 'required'],
            [['game_id', 'sort', 'status', 'create_time'], 'integer'],
            [['name', 'win_ids'], 'string', 'max' => 128],
            [['instruction'], 'string', 'max' => 255],
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
            'instruction' => '奖项描述',
            'win_ids' => '获奖作品id,用“，”分割;例如 2,3,6,1',
            'sort' => '排序',
            'status' => '状态',
            'create_time' => '创建时间',
        ];
    }
}
