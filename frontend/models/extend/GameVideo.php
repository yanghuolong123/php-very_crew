<?php

namespace app\models\extend;

use Yii;
use app\models\extend\Video;

class GameVideo extends \app\models\native\TblGameVideo {

    public static function gameVote($videoId, $openId) {
        $videoModel = Video::findOne($videoId);
        if (empty($videoId)) {
            return;
        }

        $collection = Yii::$app->mongodb->getCollection('game_vote_record');
        if (!empty($collection->findOne(['game_video_id' => $videoId, 'open_id' => $openId]))) {
            return '亲，你已经对作品 《' . $videoModel->title . '》投票过了，感谢你的参与!';
        }

        self::updateAllCounters(['votes' => 1], ['video_id' => $videoId]);
        $collection->insert(['game_video_id' => $videoId, 'open_id' => $openId, 'time' => DATETIME]);

        return '亲，感谢你对作品 《' . $videoModel->title . '》投票了一票!';
    }

}
