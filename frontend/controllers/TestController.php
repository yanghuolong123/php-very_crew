<?php

namespace app\controllers;

use Yii;

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
        
        Yii::$app->mailer->compose()
                ->setTo('yanghuolong@zhisland.com')
                ->setFrom(['yhl27ml@163.com' => 'jason'])
                ->setSubject("mailer邮件测试22")
                ->setTextBody('Hello World!')
                ->send();
    }

}
