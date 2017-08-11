<?php

namespace app\controllers;

use Yii;
use app\models\extend\Order;

class OrderController extends \app\util\BaseController {

    public function actionIspay() {
        $orderId = Yii::$app->request->post('orderId');
        $model = Order::findOne($orderId);
        if (empty($model) || $model->status != 1) {
            $this->sendRes(false);
        }

        $this->sendRes();
    }

}
