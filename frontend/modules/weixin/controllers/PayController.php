<?php

namespace app\modules\weixin\controllers;

use Yii;

class PayController extends \app\util\BaseController {

    public function actionQrcode() {
        error_reporting(E_ERROR);

        require_once Yii::$app->getBasePath() . '/modules/weixin/components/wxpay/phpqrcode/phpqrcode.php';
        $url = urldecode($_GET["data"]);
        \QRcode::png($url);
    }

    public function actionNotify() {
        error_reporting(E_ERROR);
        //初始化日志
        $notify = new \app\modules\weixin\components\wxpay\PayNotifyCallBack();
        $logHandler = new \CLogFileHandler(BASE_PATH. "/logs/wxpay_" . date('Y-m-d') . '.log');
        $log = \Log::Init($logHandler, 15);
        \Log::DEBUG("begin notify");        
        
        $notify->Handle(false);
    }

}
