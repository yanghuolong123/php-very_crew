<?php

namespace app\controllers;

use Yii;
use app\models\extend\User;
use app\models\extend\UserProfile;

class UserController extends \yii\web\Controller {

    public function actionIndex() {
        $searchModel = new \app\models\search\UserSearch();
        $searchModel->status = 1;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 12;
        
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        $model = User::findOne($id);
        if(empty($model)) {
            throw new \yii\web\NotFoundHttpException('user not exist!');
        }
        $profie = UserProfile::findOne(['uid' => $id]);
        $perVideo = \app\models\extend\Video::find()->where(['uid' => $id, 'status' => 1])->orderBy('createtime desc')->limit(4)->all();
        $albums = \app\models\extend\UserAlbum::find()->where(['uid' => $id, 'status' => 0])->orderBy('createtime desc')->all();
        
        return $this->render('view', [
                    'model' => $model,
                    'profile' => empty($profie) ? new UserProfile() : $profie,
                    'perVideo' => $perVideo,
                    'albums' => $albums,
        ]);
    }

}
