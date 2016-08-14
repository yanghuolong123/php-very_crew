<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\extend\Video;
use app\util\CommonUtil;

/**
 * php yii convert-video/index
 */
class ConvertVideoController extends Controller {

    public $list_key = 'convert_video_list';

    public function actionIndex() {
        //var_dump(Yii::$app->redis->LRANGE($this->list_key, 0, 10));
        $vido_id = Yii::$app->redis->RPOP($this->list_key);
        if (empty($vido_id)) {
            return;
        }

        $model = Video::findOne(['id' => $vido_id]);
        if (!empty($model)) {
            $filePath = Yii::getAlias("@app/web") . $model->file;
            $newFile = strstr($model->file, '.', true) . '.mp4';
            $newFile = dirname($newFile) . '/code_' . basename($newFile);
            $newFilePath = Yii::getAlias("@app/web") . $newFile;
            $cmd = 'ffmpeg -i ' . $filePath . ' -y -vcodec libx264 -ar 22050 ' . $newFilePath;
            echo "\n===========================================\n";
            echo exec($cmd);
            //echo "$cmd\n";
            echo "\n===========================================\n";
            $model->updateAttributes(['status' => 1, 'file' => $newFile]);

            $videoInfo = CommonUtil::video_info($newFilePath);
            //print_r($videoInfo);
            if (isset($videoInfo['duration'])) {
                $model->updateAttributes(['duration' => strstr($videoInfo['duration'], '.', true)]);
            }
        }
    }

}
