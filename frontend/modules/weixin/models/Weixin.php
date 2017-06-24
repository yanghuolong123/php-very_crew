<?php

namespace app\modules\weixin\models;

use Yii;
use app\util\CommonUtil;
use app\util\HttpUtil;
use app\util\LogUtil;

class Weixin {

    public $token = 'feichangjuzu123456';
    public $appid = 'wx2705fb0b58b923b6';
    public $secret = '63b572bc483358797be65ea66b156290';
    public $api_url = 'https://api.weixin.qq.com';
    private $_accessToken;

    public function __construct() {
        $this->_accessToken = $this->getAccessToken();
    }

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
        if (isset(Yii::$app->request->serverName) && Yii::$app->request->serverName == 'my.frontend.verycrew.com') {
            return '';
        }
        $cache = Yii::$app->cache;
        $this->_accessToken = $cache->get('access_token_' . $this->appid);
        if (!empty($this->_accessToken)) {
            return $this->_accessToken;
        }

        $url = $this->api_url . '/cgi-bin/token?grant_type=client_credential&appid=' . $this->appid . '&secret=' . $this->secret;
        $data = json_decode(HttpUtil::curl_get($url), true);

        if (isset($data['access_token']) && isset($data['expires_in'])) {
            $this->_accessToken = $data['access_token'];
            $cache->set('access_token_' . $this->appid, $data['access_token'], $data['expires_in'] - 3600);
        }

        return $this->_accessToken;
    }

    public function urlencodeArr($arr) {
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

    /**
     * 主动发消息
     * 
     * @param type $arr
     * @param type $other
     * @param type $is_save
     */
    public function sendMsg($arr, $is_save = true) {
        $url = $this->api_url . '/cgi-bin/message/custom/send?access_token=' . $this->_accessToken;
        $arrSend = $this->urlencodeArr($arr);
        $data = HttpUtil::curl_post($url, urldecode(json_encode($arrSend)));
        $data = json_decode($data, TRUE);

        if ($is_save) {
            $mongo = Yii::$app->mongodb;
            $arr['create_time'] = TIMESTAMP;
            $arr['create_datetime'] = date('Y-m-d H:i:s', TIMESTAMP);
            $arr['return'] = $data;
            $mongo->getCollection('weixin_send')->insert($arr);
            $mongo->close();
        }

        return $data;
    }

    /**
     * 上传文件
     * 
     * @param type $file
     * @param type $type
     * @param type $is_save
     * @return type
     */
    public function uploadFile($file, $type = 'image', $is_save = false) {

        $url = 'http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=' . $this->_accessToken . '&type=' . $type;
        $data = HttpUtil::curl_post($url, array('media' => '@' . $file));
        $data = json_decode($data, true);

        if ($is_save) {
            $data['file'] = $file;
            $data['create_time'] = isset($data['create_at']) ? $data['create_at'] : TIMESTAMP;
            $data['create_datetime'] = date('Y-m-d H:i:s', $data['create_time']);
            Yii::$app->mongodb->getCollection('weixin_upload')->insert($data);
        }

        return $data;
    }

    /**
     * 生成场景二维码
     * 
     * @param type $scene_id
     * @param type $expire
     * @return string
     */
    public function getQrCodeImg($scene_id, $expire = 1800, $isPermanent = false, $prefix = '') {
        $cache = Yii::$app->cache;
        $imgUrl = $cache->get('getQrCodeImg_' . $scene_id);
        if (!empty($imgUrl)) {
            LogUtil::logs('wx', "cache qrcodeImg url： $imgUrl");
            return $imgUrl;
        }

        $url = $this->api_url . '/cgi-bin/qrcode/create?access_token=' . $this->_accessToken;
        $arr = $isPermanent ? [
            'action_name' => 'QR_LIMIT_STR_SCENE',
            'action_info' => array('scene' => array('scene_str' => $prefix . $scene_id)),
                ] : [
            'expire_seconds' => $expire,
            'action_name' => 'QR_SCENE',
            'action_info' => array('scene' => array('scene_id' => $scene_id)),
        ];
        $data = HttpUtil::curl_post($url, json_encode($arr));
        $data = json_decode($data, true);
        if (isset($data['ticket']) && !empty($data['ticket'])) {
            //return Html::img('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . $data['ticket']);
            $imgUrl = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . $data['ticket'];
            $cache->set('getQrCodeImg_' . $scene_id, $imgUrl, $expire);
            return $imgUrl;
        }

        return 'error';
    }

    /**
     * 查询菜单
     * 
     * @param type $wid
     * @return type
     */
    public function queryMenu() {
        $url = $this->api_url . '/cgi-bin/menu/get?access_token=' . $this->_accessToken;
        $data = HttpUtil::curl_get($url);

        return json_decode($data, true);
    }

    /**
     * 生成菜单
     * 
     * @param type $wid
     * @param type $menu
     * @return type
     */
    public function createMenu($menu) {
        $url = $this->api_url . '/cgi-bin/menu/create?access_token=' . $this->_accessToken;
        $menu = $this->urlencodeArr($menu);
        $data = HttpUtil::curl_post($url, urldecode(json_encode($menu)));

        return json_decode($data, true);
    }

}
