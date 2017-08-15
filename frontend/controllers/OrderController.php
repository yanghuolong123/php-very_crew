<?php

namespace app\controllers;

use Yii;
use app\models\extend\Order;

class OrderController extends \app\components\ext\BaseController {

    public function actionIspay() {
        $orderId = Yii::$app->request->post('orderId');
        $model = Order::findOne($orderId);
        if (empty($model) || $model->status != 1) {
            $this->sendRes(false);
        }

        $this->sendRes();
    }

}
