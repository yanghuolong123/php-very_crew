<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use app\util\CommonUtil;

class TestController extends \app\util\BaseController {

    public function actionIndex() {
        //echo Yii::$app->request->serverName;
        $jssdk = new \app\modules\weixin\models\JSSDK();
    $signPackage = $jssdk->GetSignPackage();
    echo '<pre>';
    var_dump($signPackage);
    echo '</pre>';
        //$weixin = new \app\modules\weixin\models\Weixin();
        //echo $weixin->getQrCodeImg(11);
        //$data = $weixin->uploadFile("/home/yanghuolong/桌面/非常剧组/game1.png");
//        $arr = array(
//            'touser' => 'CDATA[oTbmFxG5r1WRrHdb32O5y2aSAIkc',
//            'msgtype' => 'text',
//            'text' => array(
//                'content' => '亲，您的微信已和易家帐号成功绑定，欢迎您的使用！',
//        ));
//        $data = $weixin->sendMsg($arr);

//        $menu = json_decode(file_get_contents(BASE_PATH . '/doc/weixin-menu.txt'), true);
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

}
