<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_game_video".
 *
 * @property integer $id
 * @property integer $game_id
 * @property integer $video_id
 * @property integer $user_id
 * @property integer $votes
 * @property integer $score
 * @property string $remark
 * @property integer $status
 * @property integer $createtime
 */
class TblGameVideo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_game_video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id', 'video_id', 'user_id', 'votes', 'score', 'remark', 'status', 'createtime'], 'required'],
            [['game_id', 'video_id', 'user_id', 'votes', 'score', 'status', 'createtime'], 'integer'],
            [['remark'], 'string', 'max' => 255],
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
            'video_id' => '作品id',
            'user_id' => '参与人id',
            'votes' => '投票数',
            'score' => '分数',
            'remark' => '点评',
            'status' => '状态：-1删除，0正常',
            'createtime' => '创建时间',
        ];
    }
}
