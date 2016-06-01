<?php

namespace app\controllers;

use Yii;
use app\models\extend\Comment;
use app\models\extend\User;
use app\models\extend\Video;

class CommentController extends \app\util\BaseController {

    public function actionCreate() {
        $model = new Comment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->createtime = date('Y-m-d H:i:s', $model->createtime);
            $arr = \yii\helpers\ArrayHelper::toArray($model);
            $arr['avatar'] = User::getInfo($model->uid)->avatar;
            $arr['nickname'] = User::getInfo($model->uid)->nickname;

            if (!empty($model->vid)) {
                $videoModel = Video::findOne($model->vid);
                $videoModel->updateCounters(['comments' => 1]);
            }

            $this->sendRes(true, 'success', $arr);
        }

        $this->sendRes(false);
    }

}
