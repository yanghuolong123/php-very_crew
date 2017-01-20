<?php

namespace app\util;

use Yii;
use yii\web\UploadedFile;

class BaseController extends \yii\web\Controller {

    public $enableCsrfValidation = false;

    public function actionUploadFile() {
        $file = UploadedFile::getInstanceByName('file');
        $relatePath = '/uploads/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
        $filePath = Yii::$app->basePath . '/web' . $relatePath;
        $fileName = time() . mt_rand(10000, 99999);
        if (!is_dir($filePath)) {
            mkdir($filePath, 0777, true);
            chmod($filePath, 0777);
        }

        if ($file) {
            $file->saveAs($filePath . $fileName . '.' . $file->extension);
            chmod($filePath . $fileName . '.' . $file->extension, 0777);
            $this->sendRes(true, '', $relatePath . $fileName . '.' . $file->extension);
        } else {
            $this->sendRes(false);
        }
    }

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

    protected function sendJsonRpc($success = true, $msg = '', $data = '', $code = '') {
        $arr['jsonrpc'] = '2.0';
        $arr['success'] = $success;
        $arr['code'] = $code;
        $arr['msg'] = $msg;
        $arr['data'] = $data;

        header('Content-type: application/json; charset=UTF-8');

        die(json_encode($arr));
    }

}
