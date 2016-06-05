<?php

namespace app\controllers;

use Yii;
use app\models\extend\User;
use app\models\extend\UserProfile;

class UserController extends \yii\web\Controller {

    public function actionIndex() {
        
        return $this->render('index', [
            
        ]);
    }

    public function actionView($id) {
        $model = User::findOne($id);
        $profie = UserProfile::findOne(['uid' => $id]);
        $perVideo = \app\models\extend\Video::find()->where(['uid' => $id, 'status' => 1])->orderBy('createtime desc')->limit(4)->all();

        return $this->render('view', [
                    'model' => $model,
                    'profile' => $profie,
                    'perVideo' => $perVideo,
        ]);
    }

}
