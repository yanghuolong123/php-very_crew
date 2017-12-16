<?php

namespace app\modules\weixin\models;

use app\models\extend\GameVideo;
use Yii;

class ListenScan extends Listen {

    public function __construct($params = array()) {
        parent::__construct($params);
    }

    public function listen() {
        if (($this->params['MsgType'] == 'event') && ($this->params['Event'] == 'SCAN')) {
            // 参赛作品投票
            $eventKey = $this->params['EventKey'];

            if (is_numeric($eventKey)) {
                $msg = GameVideo::gameVote($eventKey, $this->params['FromUserName']);

                if (empty($msg)) {
                    return;
                }

                $msgArr['ToUserName'] = $this->params['FromUserName'];
                $msgArr['FromUserName'] = $this->params['ToUserName'];
                $msgArr['CreateTime'] = TIMESTAMP;
                $msgArr['MsgType'] = 'text';
                $msgArr['Content'] = $msg;

                $this->sendMsg($msgArr);
            } elseif (strpos($eventKey, 'login_') !== false) {
                $model = new \app\modules\weixin\models\Weixin();
                $data = $model->getWeixUserinfo($this->params['FromUserName']);

                $cache = Yii::$app->cache;
                $cache->set($this->params['EventKey'], $data, 18000);
            }
        }

        return;
    }

}
