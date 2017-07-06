<?php

namespace app\models\extend;

use Yii;
use app\models\extend\Video;

class Games extends \app\models\native\TblGames {

    public function rules() {
        return [
            [['name', 'content', 'sort', 'status', 'begin_time', 'end_time'], 'required'],
            [['type', 'sort', 'status', 'number', 'createtime'], 'integer'],
            [['content', 'result'], 'string'],
            [['name', 'logo'], 'string', 'max' => 128],
            ['end_time', 'compare', 'compareAttribute' => 'begin_time', 'operator' => '>', 'message' => '结束时间需大于开始时间'],
        ];
    }

    public function beforeValidate() {
        $this->begin_time = strtotime($this->begin_time);
        $this->end_time = strtotime($this->end_time);

        return parent::beforeValidate();
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->createtime = time();
        } else {
            $videoArr = Yii::$app->db->createCommand('select video_id from tbl_game_video where status=0 and game_id=' . $this->id)->queryColumn();
            if (!empty($videoArr)) {
                Video::updateAll(['status' => ($this->status < 1 ? 2 : 1)], ['in', 'id', $videoArr]);
            }
        }

        return parent::beforeSave($insert);
    }

    public static function getStatusArr($isArr = true, $status = 0) {
        $arr = [
            0 => '作品上传进行中',
            1 => '投票进行中',
            2 => '大赛结果评比中',
            3 => '大赛已结束',
        ];

        return $isArr ? $arr : (isset($arr[$status]) ? $arr[$status] : '');
    }

}
