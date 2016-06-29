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
            chmod($filePath, 0777);
        }

        if ($file) {
            $file->saveAs($filePath . $fileName . '.' . $file->extension);
            $this->sendRes(true, '', $relatePath . $fileName . '.' . $file->extension);
        } else {
            $this->sendRes(false);
        }
    }

    public function actionCutImg() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $targ_w = $targ_h = 150;
            $jpeg_quality = 90;

            $pathInfo = pathinfo($_POST['cropImg']);
            $relatePath = $pathInfo['dirname'] . '/' . 'thumb_' . $pathInfo['filename'] . '.' . $pathInfo['extension'];
            $src = Yii::$app->basePath . '/web' .$relatePath ;
            copy(Yii::$app->basePath . '/web' . $_POST['cropImg'], $src);
            $img_r = imagecreatefromjpeg($src);
            $dst_r = ImageCreateTrueColor($targ_w, $targ_h);

            imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);

            imagejpeg($dst_r, $src);
            imagedestroy($dst_r);
//            header('Content-type: image/jpeg');
//            imagejpeg($dst_r, null, $jpeg_quality);

            $this->sendRes(true,'ok', $relatePath);
        }

        $this->sendRes(false);
    }

}
