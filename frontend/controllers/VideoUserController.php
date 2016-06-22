<?php

namespace app\controllers;

use Yii;
use app\models\extend\VideoUser;
use app\models\search\VideoUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class VideoUserController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex($video_id) {
        $searchModel = new VideoUserSearch();
        $searchModel->video_id = $video_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate() {
        $model = new VideoUser();
        $uid = Yii::$app->request->get('uid');
        $model->uid = $uid;
        $model->is_star = empty($model->is_star) ? 0 : $model->is_star;

        $model->status = 1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'video_id' => $model->video_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'video_id' => $model->video_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->updateAttributes(['status' => -1]);

        return $this->redirect(['index', ['video_id' => $model->video_id]]);
    }

    protected function findModel($id) {
        if (($model = VideoUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
