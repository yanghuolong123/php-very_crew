<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class TestController extends \app\util\BaseController {

    public function actionIndex() {
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
