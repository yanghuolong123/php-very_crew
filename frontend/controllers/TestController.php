<?php

namespace app\controllers;

use Yii;

class TestController extends \app\util\BaseController {

    public function actionIndex() {
        //echo phpinfo();
        $collection = Yii::$app->mongodb->getCollection('customer');
        //$collection->insert(['name' => 'John Smith', 'status' => 1]);
        $data = $collection->findOne(['name' => 'John Smith', 'status' => 1]);
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        
//        Yii::$app->mailer->compose()
//                ->setTo('yanghuolong@zhisland.com')
//                ->setFrom(['yhl27ml@163.com' => 'jason'])
//                ->setSubject("mailer邮件测试")
//                ->setTextBody('Hello World!')
//                ->send();
    }

}
