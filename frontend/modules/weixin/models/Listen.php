<?php

namespace app\modules\weixin\models;

use Yii;
use app\util\XmlUtil;

abstract class Listen {

    public $params;

    public function __construct($params = array()) {
        $this->params = $params;
    }

    abstract public function listen();

    public function sendMsg($arr, $is_save = FALSE, $other = array()) {
        $xmlStr = XmlUtil::arrToXmlStr($arr);
        echo $xmlStr;
        if ($is_save) {
            $mongo = Yii::$app->mongodb;
            $arr['create_datetime'] = isset($arr['CreateTime']) ? date('Y-m-d H:i:s', $arr['CreateTime']) : date('Y-m-d H:i:s', TIMESTAMP);
            $arr['other'] = $other;
            $mongo->getCollection('weixin_send')->insert($arr);
            $mongo->close();
        }
        exit(0);
    }

}
