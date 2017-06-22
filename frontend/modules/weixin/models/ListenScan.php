<?php

namespace app\modules\weixin\models;

use app\models\extend\GameVideo;
use app\util\LogUtil;

class ListenScan extends Listen {

    public function __construct($params = array()) {
        parent::__construct($params);
    }

    public function listen() {
        if (($this->params['MsgType'] == 'event') && ($this->params['Event'] == 'SCAN')) {
            // 参赛作品投票
            $videoId = $this->params['EventKey'];
            
           $msg = GameVideo::gameVote($videoId, $this->params['FromUserName']);
//
//            if (empty($msg)) {
//                return;
//            }

           LogUtil::logs('wx', "msg:$msg ");
            $msgArr['ToUserName'] = $this->params['FromUserName'];
            $msgArr['FromUserName'] = $this->params['ToUserName'];
            $msgArr['CreateTime'] = TIMESTAMP;
            $msgArr['MsgType'] = 'text';
            $msgArr['Content'] = "dssdsd";

            $this->sendMsg($msgArr);
        }

        return;
    }

}
