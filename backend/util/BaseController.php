<?php

namespace app\util;

use Yii;

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

    public function actionTips($tips_view) {
        $data = Yii::$app->request->get('data');
        return $this->render($tips_view, [
                    'data' => empty($data) ? '' : $data,
        ]);
    }

}
