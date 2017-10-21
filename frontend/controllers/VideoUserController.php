<?php

namespace app\controllers;

use Yii;
use app\models\extend\VideoUser;
use app\models\search\VideoUserSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\extend\User;

class VideoUserController extends \app\components\ext\BaseController {

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
        $searchModel->status = 0;
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
        $uid = Yii::$app->request->get('uid');
        $video_id = Yii::$app->request->get('video_id');
        if (empty($uid)) {
            return $this->redirect(['site/info', 'msg' => '没有指定具体成员']);
        }

        $model = new VideoUser();
        $model->uid = $uid;
        $model->video_id = $video_id;
        $model->type = 1;

        if (VideoUser::find()->where(['uid' => $uid, 'video_id' => $model->video_id])->exists()) {
            return $this->redirect(['site/info', 'msg' => '该用户已经是此作品成员']);
        }

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

        return $this->redirect(['index', 'video_id' => $model->video_id]);
    }

    protected function findModel($id) {
        if (($model = VideoUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUserSearch() {
        $search = trim(Yii::$app->request->post('search'));
        $video_id = Yii::$app->request->post('video_id');

        $condition = is_numeric($search) ? ['id' => $search, 'status' => 1] : ['nickname' => $search, 'status' => 1];
        $userModel = User::find()->where($condition)->orderBy('id desc')->all();

        return $this->renderAjax('user-search', [
                    'userModel' => $userModel,
                    'video_id' => $video_id,
        ]);
    }
    
    public function actionBatchUpdate() {
        $videoUsers = $_POST['videoUser'];
        $videoId = $_POST['video_id'];
        if(!is_array($videoUsers)) {
            throw new NotFoundHttpException('请求错误!');
        }
        foreach ($videoUsers as $key=>$role) {
            $model = VideoUser::findOne($key);
            $model->role_name = $role['role_name'];
            $model->instruction = $role['instruction'];
            $model->save();
        }
        
        return $this->redirect(['video/view', 'id' => $videoId]);
    }

}
