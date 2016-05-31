<?php

namespace app\controllers;

use Yii;
use yii\web\UploadedFile;

class UploadController extends \app\util\BaseController {

    public $enableCsrfValidation = false;

    public function actionUploadFile() {
        $file = UploadedFile::getInstanceByName('file');
        $relatePath = '/uploads/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
        $filePath = Yii::$app->basePath . '/web' . $relatePath;
        $fileName = time() . mt_rand(10000, 99999);
        if (!is_dir($filePath)) {
            mkdir($filePath, 0777, true);
        }

        if ($file) {
            $file->saveAs($filePath . $fileName . '.' . $file->extension);
            $this->sendRes(true, '', $relatePath . $fileName . '.' . $file->extension);
        } else {
            $this->sendRes(false);
        }
    }

}
