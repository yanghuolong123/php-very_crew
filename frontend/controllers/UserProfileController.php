<?php

namespace app\controllers;

use Yii;
use app\models\extend\UserProfile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\extend\User;

class UserProfileController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['update'],
                'rules' => [
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

//    public function actionIndex() {
//        $searchModel = new UserProfileSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
//        ]);
//    }

    public function actionView($uid) {
        return $this->render('view', [
                    'model' => $this->findModel($uid),
                    'userModel' => User::findOne($uid),
        ]);
    }

//    public function actionCreate() {
//        $model = new UserProfile();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                        'model' => $model,
//            ]);
//        }
//    }

    public function actionUpdate($uid) {
        if (Yii::$app->user->id != $uid) {
            throw new NotFoundHttpException('亲，您不能编辑别人的资料.');
        }
        $userModel = \app\models\extend\User::findOne($uid);
        if (empty($userModel)) {
            throw new NotFoundHttpException('此用户不存在.');
        }
        $userModel->setScenario("perfect");

        $model = $this->findModel($userModel->id);
        $model->uid = $uid;

        if ($model->load(Yii::$app->request->post()) && $userModel->load(Yii::$app->request->post()) && $userModel->save() && $model->save()) {
            return $this->redirect(['user/view', 'id' => $model->uid]);
        } else {
            $model->good_at_job = is_array($model->good_at_job) ? $model->good_at_job : explode(',', trim($model->good_at_job, ','));
            $model->speciality = is_array($model->speciality) ? $model->speciality : explode(',', trim($model->speciality, ','));
            $model->usingtime = is_array($model->usingtime) ? $model->usingtime : explode(',', trim($model->usingtime, ','));

            return $this->render('update', [
                        'model' => $model,
                        'userModel' => $userModel,
            ]);
        }
    }

//    public function actionDelete($id) {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    protected function findModel($uid) {
        if (($model = UserProfile::findOne(['uid' => $uid])) !== null) {
            return $model;
        } else {
            return new UserProfile();
            //throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
