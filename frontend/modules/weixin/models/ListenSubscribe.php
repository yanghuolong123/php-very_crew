<?php

namespace app\modules\weixin\models;

class ListenSubscribe extends Listen {

    public function __construct($token, $params = array()) {
        parent::__construct($token, $params);
    }

    public function listen() {
        if (($this->params['MsgType'] == 'event') && ($this->params['Event'] == 'subscribe')) {
            $msgArr['ToUserName'] = $this->params['FromUserName'];
            $msgArr['FromUserName'] = $this->params['ToUserName'];
            $msgArr['CreateTime'] = TIMESTAMP;
            $msgArr['MsgType'] = 'text';
            $msgArr['Content'] = '亲，您好，感谢你的关注';

            $this->sendMsg($msgArr);
        }

        return;
    }

}
