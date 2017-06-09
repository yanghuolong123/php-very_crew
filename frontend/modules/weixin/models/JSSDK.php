<?php

namespace app\modules\weixin\models;

use Yii;
use app\modules\weixin\models\Weixin;
use app\util\HttpUtil;

class JSSDK {

    private $appId;
    private $appSecret;
    private $accessToken;

    public function __construct() {
        $weixin = new Weixin();
        $this->appId = $weixin->appid;
        $this->appSecret = $weixin->secret;
        $this->accessToken = $weixin->getAccessToken();
    }

    public function getSignPackage($url = '') {
        $jsapiTicket = $this->getJsApiTicket();

        if (empty($url)) {
            // 注意 URL 一定要动态获取，不能 hardcode.
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        }

        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId" => $this->appId,
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket() {
        if (Yii::$app->request->serverName == 'my.frontend.verycrew.com') {
            return '';
        }
        $cache = Yii::$app->cache;
        $ticket = $cache->get("jsapi_ticket_" . $this->appId);
        if (!empty($ticket)) {
            return $ticket;
        }

        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$this->accessToken";
        $res = json_decode(HttpUtil::curl_get($url), true);

        if (isset($res['ticket']) && !empty($res['ticket'])) {
            $ticket = $res['ticket'];
            $cache->set("jsapi_ticket_" . $this->appId, $ticket, 3600);
        }

        return $ticket;
    }

}
