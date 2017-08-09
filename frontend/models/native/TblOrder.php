<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_order".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $product_id
 * @property string $orderno
 * @property integer $uid
 * @property string $username
 * @property integer $pay_type
 * @property integer $status
 * @property string $amount
 * @property string $transaction_id
 * @property integer $create_time
 * @property integer $pay_time
 * @property string $msg
 * @property string $remark
 */
class TblOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'product_id', 'orderno', 'uid', 'username', 'pay_type', 'status', 'amount', 'transaction_id', 'create_time', 'pay_time', 'msg', 'remark'], 'required'],
            [['type', 'product_id', 'uid', 'pay_type', 'status', 'create_time', 'pay_time'], 'integer'],
            [['amount'], 'number'],
            [['orderno', 'transaction_id'], 'string', 'max' => 128],
            [['username'], 'string', 'max' => 64],
            [['msg', 'remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '类型:1打赏作品',
            'product_id' => '商品id',
            'orderno' => '订单号',
            'uid' => '用户id',
            'username' => '用户名称',
            'pay_type' => '支付类型:1微信，2支付宝',
            'status' => '状态：0未支付，1已支付',
            'amount' => '金额',
            'transaction_id' => '业务id',
            'create_time' => '创建时间',
            'pay_time' => '支付时间',
            'msg' => '留言',
            'remark' => '备注',
        ];
    }
}
