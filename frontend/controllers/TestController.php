<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use app\util\CommonUtil;

class TestController extends \app\components\ext\BaseController {
    
    public function actionQimg() {
        $model = new \app\modules\weixin\models\Weixin();
        echo $model->getQrCodeImg(68);
    }

    public function actionIndex() {
        //\app\models\extend\Order::updatePaySuccess("201708091653322401", "dsdsdssd");
        
//        $notify = new \app\modules\weixin\components\wxpay\PayNotifyCallBack();
//        $logHandler = new \CLogFileHandler(BASE_PATH. "/logs/wxpay_" . date('Y-m-d') . '.log');
//        $log = \Log::Init($logHandler, 15);
//        //var_dump($notify->Queryorder('4000142001201708085145553608'));
//        $dataStr = '{"appid":"wx2705fb0b58b923b6","attach":"\u975e\u5e38\u5267\u7ec42","bank_type":"CFT","cash_fee":"1","fee_type":"CNY","is_subscribe":"Y","mch_id":"1482346342","nonce_str":"jiwl9iqhdv9fydyclnc2yzhbx8x13x1q","openid":"oTbmFxG5r1WRrHdb32O5y2aSAIkc","out_trade_no":"148234634220170808144544","result_code":"SUCCESS","return_code":"SUCCESS","sign":"56B828E29E4B91E1E03C4BB5794131EC","time_end":"20170808144803","total_fee":"1","trade_type":"NATIVE","transaction_id":"4000142001201708085141954829"}';
//        //var_dump(json_decode($dataStr, TRUE));
//        var_dump($notify->NotifyCallBack(json_decode($dataStr, TRUE)));
        
        //var_dump(Yii::$app->request->url);

//        /var_dump(\app\models\extend\Video::getIdsBySearchName('啊的萨发大赛'));
        //$cache = Yii::$app->cache;
        //$cache->set('test_1', 'test1111111111', 60);
        //echo $cache->get('test_1').':aaaaa';
        //$cache->flush();
//        $cache = Yii::$app->cache;
//        echo $cache->get("getQrCodeImg_76");
//        //$cache->flush();
        // echo trim('《too bad》', '《..》');
        //echo Yii::$app->request->serverName;
//        $jssdk = new \app\modules\weixin\models\JSSDK();
//    $signPackage = $jssdk->GetSignPackage();
//    echo '<pre>';
//    var_dump($signPackage);
//    echo '</pre>';
//        $weixin = new \app\modules\weixin\models\Weixin();
//        echo $weixin->getQrCodeImg(73);
        //$data = $weixin->uploadFile("/home/yanghuolong/桌面/非常剧组/game1.png");
//        $arr = array(
//            'touser' => 'CDATA[oTbmFxG5r1WRrHdb32O5y2aSAIkc',
//            'msgtype' => 'text',
//            'text' => array(
//                'content' => '亲，您的微信已和易家帐号成功绑定，欢迎您的使用！',
//        ));
//        $data = $weixin->sendMsg($arr);
//        $menu = json_decode(file_get_contents(BASE_PATH . '/doc/weixin-menu.txt'), true);
//        $weixin = new \app\modules\weixin\models\Weixin();
//        $data = $weixin->createMenu($menu);
//
//        echo '<pre>';
//        var_dump($data);
//        echo '</pre>';
        //echo CommonUtil::getFileExtension("11/111.mp4");
        //logs('test', "dsdsdssd");
//        echo TIMESTAMP;
//        echo "\n";
//        echo DATETIME;
//        echo "\n";
//        echo BASE_PATH;
        //echo phpinfo();
//        $collection = Yii::$app->mongodb->getCollection('customer');
//        //$collection->insert(['name' => 'John Smith', 'status' => 1]);
//        $data = $collection->findOne(['name' => 'John Smith', 'status' => 1]); 
//        Yii::$app->mailer->compose()
//                ->setTo('yanghuolong@zhisland.com')
//                ->setFrom(['yhl27ml@163.com' => 'jason'])
//                ->setSubject("mailer邮件测试22")
//                ->setTextBody('Hello World!')
//                ->send();
//        Yii::$app->mailer->compose()
//                    ->setTo('yanghuolong@zhisland.com')
//                    ->setFrom(['yhl27ml@163.com' => '非常剧组'])
//                    ->setSubject("非常剧组大赛投票")
//                    ->setHtmlBody('欢迎您参加大赛投票，' . Html::a('进行投票', Url::to(['game/email-vote', 'email'=>'yanghuolong@zhisland.com', 'gameVideoId' => 1])))
//                    ->send();
    }

    public function actionClearWeixin() {
        $cache = Yii::$app->cache;
        $cache->delete('access_token_wx2705fb0b58b923b6');
        $cache->delete('jsapi_ticket_wx2705fb0b58b923b6');

        echo '已清除掉 微信 access_token, jsap_ticket 缓存!';
    }

    public function actionWxpay() {
        
        $order = \app\models\extend\Order::generateOrder(0.01, 12);
        //var_dump($order);
        //die;

        //模式二
        /**
         * 流程：
         * 1、调用统一下单，取得code_url，生成二维码
         * 2、用户扫描二维码，进行支付
         * 3、支付完成之后，微信服务器会通知支付成功
         * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
         */
        //require_once Yii::$app->getBasePath().'/modules/weixin/components/wxpay/NativePay.php';
        $notify = new \app\modules\weixin\components\wxpay\NativePay();
        $input = new \WxPayUnifiedOrder();
        $input->SetBody("非常剧组1");
        $input->SetAttach("非常剧组2");
        $input->SetOut_trade_no($order->orderno);
        $input->SetTotal_fee($order->amount*100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("非常剧组3");
        $input->SetNotify_url(Url::to(['/weixin/pay/notify'], TRUE));
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id($order->product_id);
        $result = $notify->GetPayUrl($input);
        //var_dump($result);die;
        $url2 = $result["code_url"];
        
        //echo $url2;
        //echo Url::to(['/weixin/pay/notify'], TRUE);

        return $this->render('wxpay', [
            'url' => $url2,
        ]);
    }

}
