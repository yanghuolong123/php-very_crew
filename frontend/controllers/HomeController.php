<?php

namespace app\controllers;

class HomeController extends \yii\web\Controller {

    public function actionIndex() {
        $banners = \app\models\extend\Advertisement::getAdByPos('banner');
        $recomVideos = \app\models\extend\Video::find()->where(['status' => 1])->orderBy('createtime desc')->limit(8)->all();
        $latestPlans = \app\models\extend\Plan::find()->where(['status' => 1])->orderBy('createtime desc')->limit(6)->all();
        $recomUsers = \app\models\extend\User::find()->where(['status' => 1])->limit(8)->all();

        return $this->render('index', [
                    'banners' => $banners,
                    'recomVideos' => $recomVideos,
                    'latestPlans' => $latestPlans,
                    'recomUsers' => $recomUsers,
        ]);
    }

}
