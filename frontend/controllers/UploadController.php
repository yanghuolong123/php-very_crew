<?php

namespace app\controllers;

use Yii;
use app\util\CommonUtil;

//use yii\web\UploadedFile;

class UploadController extends \app\util\BaseController {

//    public $enableCsrfValidation = false;
//
//    public function actionUploadFile() {
//        $file = UploadedFile::getInstanceByName('file');
//        $relatePath = '/uploads/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
//        $filePath = Yii::$app->basePath . '/web' . $relatePath;
//        $fileName = time() . mt_rand(10000, 99999);
//        if (!is_dir($filePath)) {
//            mkdir($filePath, 0777, true);
//            chmod($filePath, 0777);
//        }
//
//        if ($file) {
//            $file->saveAs($filePath . $fileName . '.' . $file->extension);
//            chmod($filePath . $fileName . '.' . $file->extension, 0777);
//            $this->sendRes(true, '', $relatePath . $fileName . '.' . $file->extension);
//        } else {
//            $this->sendRes(false);
//        }
//    }

    public function actionCutImg() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $targ_w = $targ_h = 150;
            $jpeg_quality = 90;

            $pathInfo = pathinfo($_POST['cropImg']);
            $relatePath = $pathInfo['dirname'] . '/' . 'thumb_' . $pathInfo['filename'] . '.' . $pathInfo['extension'];
            $src = Yii::$app->basePath . '/web' . $relatePath;
            copy(Yii::$app->basePath . '/web' . $_POST['cropImg'], $src);
            $img_r = imagecreatefromjpeg($src);
            $dst_r = ImageCreateTrueColor($targ_w, $targ_h);

            imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);

            imagejpeg($dst_r, $src);
            imagedestroy($dst_r);
//            header('Content-type: image/jpeg');
//            imagejpeg($dst_r, null, $jpeg_quality);

            $this->sendRes(true, 'ok', $relatePath);
        }

        $this->sendRes(false);
    }

    public function actionWebupload() {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");


        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit; // finish preflight CORS requests here
        }

        if (!empty($_REQUEST['debug'])) {
            $random = rand(0, intval($_REQUEST['debug']));
            if ($random === 0) {
                header("HTTP/1.0 500 Internal Server Error");
                exit;
            }
        }

        // 5 minutes execution time
        @set_time_limit(5 * 60);

        $targetDir = 'uploads/tmp';
        $uploadDir = 'uploads/' . date('Y') . '/' . date('m') . '/' . date('d');
        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
            chmod($uploadDir, 0777);
        }
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
            chmod($targetDir, 0777);
        }

        // Get a file name
        if (isset($_REQUEST["name"])) {
            $fileName = $_REQUEST["name"];
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        } else {
            $fileName = uniqid("file_");
        }

        $newFileName = time() . mt_rand(10000, 99999);
        $newFileName .= '.' . CommonUtil::getFileExtension($fileName);
        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        $uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;
        $newFilePath = $uploadDir . DIRECTORY_SEPARATOR . $newFileName;
        // Chunking might be enabled
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;

        // Remove old temp files
        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                $this->sendJsonRpc(false, 'Failed to open temp directory', '', 100);
            }

            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                // If temp file is current file proceed to the next
                if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
                    continue;
                }

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }

        // Open temp file
        if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
            $this->sendJsonRpc(false, 'Failed to open output stream', '', 102);
        }

        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                $this->sendJsonRpc(false, 'message": "Failed to move uploaded file', '', 103);
            }

            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                $this->sendJsonRpc(false, 'Failed to open input stream', '', 101);
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                $this->sendJsonRpc(false, 'Failed to open input stream', '', 101);
            }
        }

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);

        rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");

        $index = 0;
        $done = true;
        for ($index = 0; $index < $chunks; $index++) {
            if (!file_exists("{$filePath}_{$index}.part")) {
                $done = false;
                break;
            }
        }
        if ($done) {
            if (!$out = @fopen($uploadPath, "wb")) {
                $this->sendJsonRpc(false, 'Failed to open output stream', '', 102);
            }

            if (flock($out, LOCK_EX)) {
                for ($index = 0; $index < $chunks; $index++) {
                    if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
                        break;
                    }

                    while ($buff = fread($in, 4096)) {
                        fwrite($out, $buff);
                    }

                    @fclose($in);
                    @unlink("{$filePath}_{$index}.part");
                }

                flock($out, LOCK_UN);
            }
            @fclose($out);
            rename($uploadPath, $newFilePath);
            chmod($newFilePath, 0777);
        }

        // Return Success JSON-RPC response
        $this->sendJsonRpc(true, '', '/' . $newFilePath);
    }

}
