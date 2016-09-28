<?php

namespace app\util;

class RedisConnection extends \yii\redis\Connection {

    public $prefix = '';

    public function __call($name, $params) {
        if (isset($params[0])) {
            $params[0] = $this->prefix . $params[0];
        }
        return parent::__call($name, $params);
    }

}
