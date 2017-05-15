<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\util\XmlUtil;
use app\util\LogUtil;

class WeixinController extends Controller {

//    public $token = 'yanghuolonghebingbing123';
//    public $appid = 'wxa2d2cc7d8b460302';
//    public $secret = 'f36da1173c0a891fdac60da21cbb7c06';
//    public $api_url = 'https://api.weixin.qq.com';
//    private $_accessToken;
    
    public $token = 'feichangjuzu123456';
    public $appid = 'wx2705fb0b58b923b6';
    public $secret = '63b572bc483358797be65ea66b156290';
    public $api_url = 'https://api.weixin.qq.com';
    private $_accessToken;

    public function actionIndex() {
        list($echostr) = validParams(array('echostr'));

        if ($this->checkSignature()) {
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
            logs('wx', 'postStr empty!');
            exit(1);
        }
        logs('wx', 'postStr:' . var_export($postStr, true));

        libxml_disable_entity_loader(true);
        $postStr = preg_replace('/<!\[CDATA\[(.*)\]\]>/', '$1', $postStr);
        $data = XmlUtil::xml_parser($postStr);
       

        $msgArr['ToUserName'] = $data['FromUserName'];
        $msgArr['FromUserName'] = $data['ToUserName'];
        $msgArr['CreateTime'] = time();
        $msgArr['MsgType'] = 'text';
        $msgArr['Content'] = '亲，远古神龙欢迎您的到来！' . " \n 1、输入\"双色球\"，可以推荐给你幸运号码";
        $this->sendMsg($msgArr);
    }

    
 

    private function checkSignature() {
        list($signature, $timestamp, $nonce) = validParams(array('signature', 'timestamp', 'nonce'));

        $token = $this->token;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    public function sendMsg($arr) {
        echo arrToXmlStr($arr);
        exit(0);
    }

    
 
 

}
