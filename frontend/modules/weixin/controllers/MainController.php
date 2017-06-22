<?php

namespace app\modules\weixin\controllers;

use Yii;
use app\util\LogUtil;
use app\util\XmlUtil;
use app\util\CommonUtil;
use app\modules\weixin\models\Weixin;

class MainController extends \app\util\BaseController {

    public function actionIndex() {
        list($echostr) = CommonUtil::validParams(array('echostr'));

        $weixin = new Weixin();
        if ($weixin->checkSignature()) {
            if (empty($echostr)) {
                $this->responseMsg();
            } else {
                echo $echostr;
            }
        } else {
            LogUtil::logs('wx', 'valid error: ' . var_export(isset($_GET) ? $_GET : 'unknown', TRUE));
        }

        exit(0);
    }

    public function responseMsg() {
        $postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"]) ? $GLOBALS["HTTP_RAW_POST_DATA"] : '';
        if (empty($postStr)) {
            LogUtil::logs('wx', 'postStr empty!');
            exit(1);
        }
        LogUtil::logs('wx', 'postStr:' . var_export($postStr, true));

        libxml_disable_entity_loader(true);
        $postStr = preg_replace('/<!\[CDATA\[(.*)\]\]>/', '$1', $postStr);
        $data = XmlUtil::xml_parser($postStr);
        //LogUtil::logs('wx', 'data:' . var_export($data, true));

        $this->listen($data);

//        $msgArr['ToUserName'] = $data['FromUserName'];
//        $msgArr['FromUserName'] = $data['ToUserName'];
//        $msgArr['CreateTime'] = time();
//        $msgArr['MsgType'] = 'text';
//        $msgArr['Content'] = '亲，非常剧组欢迎您的到来！';
//        $this->sendMsg($msgArr);
    }

    protected function sendMsg($arr) {
        echo XmlUtil::arrToXmlStr($arr);
        exit(0);
    }

    public function listen($data) {
        // 订阅关注监听
        $listenSubscribe = new \app\modules\weixin\models\ListenSubscribe($data);
        $listenSubscribe->listen();
        
        // 场景扫描
        $listenScan = new \app\modules\weixin\models\ListenScan($data);
        $listenScan->listen();
    }

}
