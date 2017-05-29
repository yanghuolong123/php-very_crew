<?php

namespace app\modules\weixin\models;

use Yii;
use app\util\LogUtil;
use app\util\XmlUtil;
use app\util\CommonUtil;
use app\util\Constant;

class Weixin {

    public $token = 'feichangjuzu123456';
    public $appid = 'wx2705fb0b58b923b6';
    public $secret = '63b572bc483358797be65ea66b156290';
    public $api_url = 'https://api.weixin.qq.com';
    private $_accessToken;

    public function checkSignature() {
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

}
