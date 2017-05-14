<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\util\LogUtil;
use app\util\XmlUtil;
use app\util\CommonUtil;

class WeixinController extends Controller {

    public $token = 'feichangjuzu123456';
    public $appid = 'wx2705fb0b58b923b6';
    public $secret = '63b572bc483358797be65ea66b156290';
    public $api_url = 'https://api.weixin.qq.com';
    private $_accessToken;
   

    public function actionIndex() {
        LogUtil::logs('wx',"test 1111111111");
        list($echostr) = CommonUtil::validParams(array('echostr'));
        
        if ($this->checkSignature()) {
            if (empty($echostr)) {
                $this->responseMsg();
            } else {
                LogUtil::logs('wx', '$echostr:'.$echostr);
                echo $echostr;
            }
        } else {
            LogUtil::logs('wx', 'valid error: ' . var_export(isset($_GET) ? $_GET : 'unknown', TRUE));
        }

        exit(0);
    }

    public function responseMsg() {
        LogUtil::logs('wx', '1111');
        $postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"]) ? $GLOBALS["HTTP_RAW_POST_DATA"] : '';
        if (empty($postStr)) {
            LogUtil::logs('wx', 'postStr empty!');
            exit(1);
        }
        LogUtil::logs('wx', 'postStr:' . var_export($postStr, true));

        libxml_disable_entity_loader(true);
        $postStr = preg_replace('/<!\[CDATA\[(.*)\]\]>/', '$1', $postStr);
        $data = XmlUtil::xml_parser($postStr);
        // LogUtil::logs('wx', 'data:' . var_export($data, true));

        $this->listen($data);

        $msgArr['ToUserName'] = $data['FromUserName'];
        $msgArr['FromUserName'] = $data['ToUserName'];
        $msgArr['CreateTime'] = time();
        $msgArr['MsgType'] = 'text';
        $msgArr['Content'] = '亲，非常剧组欢迎您的到来！';
        $this->sendMsg($msgArr);
    }

    public function listen($data) {
        $this->subscribe($data);
    }

    // 定阅
    public function subscribe(&$data) {
        if (isset($data['Event']) && $data['Event'] == 'subscribe') {
            $msgArr['ToUserName'] = $data['FromUserName'];
            $msgArr['FromUserName'] = $data['ToUserName'];
            $msgArr['CreateTime'] = time();
            $msgArr['MsgType'] = 'text';
            $msgArr['Content'] = '亲，感谢你的支持！' . " 非常剧组欢迎您!";
            $this->sendMsg($msgArr);
        }
    }

    private function checkSignature() {
        list($signature, $timestamp, $nonce) = CommonUtil::validParams(array('signature', 'timestamp', 'nonce'));

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

    public function getAccessToken() {
        $cache = Yii::$app->cache;
        $this->_accessToken = $cache->get('access_token_' . $this->appid);
        if (!empty($this->_accessToken)) {
            return $this->_accessToken;
        }

        $url = $this->api_url . '/cgi-bin/token?grant_type=client_credential&appid=' . $this->appid . '&secret=' . $this->secret;
        $data = json_decode(curl_get($url), true);

        if (isset($data['access_token']) && isset($data['expires_in'])) {
            $this->_accessToken = $data['access_token'];
            $cache->set('access_token_' . $this->appid, $data['access_token'], $data['expires_in'] - 3600);
        }

        return $this->_accessToken;
    }

    protected function urlencodeArr($arr) {
        foreach ($arr as $key => $val) {
            if (is_scalar($val)) {
                $arr[$key] = urlencode($val);
            }
            if (is_array($val)) {
                $arr[$key] = $this->urlencodeArr($val);
            }
        }

        return $arr;
    }

}
