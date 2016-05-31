<?php

namespace app\util;

class BaseController extends \yii\web\Controller {

    protected function sendRes($success = true, $msg = '', $data = '', $code = '') {
        $arr['success'] = $success;
        $arr['code'] = $code;
        $arr['msg'] = $msg;
        $arr['data'] = $data;

        header('Content-type: application/json; charset=UTF-8');

        echo json_encode($arr);
        exit;
    }

}
