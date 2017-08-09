<?php

namespace app\models\extend;

use Yii;

class Order extends \app\models\native\TblOrder {

    public function rules() {
        return [
            [['type', 'product_id', 'orderno', 'pay_type', 'status', 'amount', 'create_time'], 'required'],
            [['type', 'product_id', 'uid', 'pay_type', 'status', 'create_time', 'pay_time'], 'integer'],
            [['amount'], 'number'],
            [['orderno', 'transaction_id'], 'string', 'max' => 128],
            [['username'], 'string', 'max' => 64],
            [['msg', 'remark'], 'string', 'max' => 255],
        ];
    }

    public static function generateOrder($amount, $productId, $type=1, $payType = 1, $msg = '', $username = '') {
        $model = new self();
        $model->type = $type;
        $model->product_id = $productId;
        $model->orderno = date('YmdHis') . mt_rand(1, 10000);
        $model->uid = Yii::$app->user->isGuest ? 0 : Yii::$app->user->id;
        $model->username = Yii::$app->user->isGuest ? $username : Yii::$app->user->identity->nickname;
        $model->pay_type = $payType;
        $model->amount = $amount;
        $model->create_time = TIMESTAMP;
        $model->msg = $msg;
        $model->save(false);

        return $model;
    }

    public static function updatePaySuccess($orderno, $transactionId) {
        $model = self::findOne(['orderno' => $orderno]);
        $model->status = 1;
        $model->pay_time = TIMESTAMP;
        $model->transaction_id = $transactionId;
        $model->save();
    }

}
