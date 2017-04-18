<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_game_apply".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $game_id
 * @property string $username
 * @property integer $amount
 * @property string $summary
 * @property integer $join_num
 * @property integer $len_minute
 * @property integer $len_second
 * @property string $condition
 * @property string $ability
 * @property string $advantage
 * @property integer $status
 * @property integer $create_time
 */
class TblGameApply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_game_apply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'game_id', 'username', 'amount', 'summary', 'join_num', 'len_minute', 'len_second', 'condition', 'ability', 'advantage', 'status', 'create_time'], 'required'],
            [['user_id', 'game_id', 'amount', 'join_num', 'len_minute', 'len_second', 'status', 'create_time'], 'integer'],
            [['username'], 'string', 'max' => 65],
            [['summary', 'condition', 'ability', 'advantage'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'game_id' => '大赛ID',
            'username' => '用户姓名',
            'amount' => '金额',
            'summary' => '拍摄计划/剧情简介',
            'join_num' => '参与人数',
            'len_minute' => '时长分钟',
            'len_second' => '时长秒',
            'condition' => '条件',
            'ability' => '能力：拍摄经验/经历/技能',
            'advantage' => '优势：其它您认为有利于您获得拍摄资助的说明',
            'status' => '状态',
            'create_time' => '创建时间',
        ];
    }
}
