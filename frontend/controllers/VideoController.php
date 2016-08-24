<?php

namespace app\controllers;

use Yii;
use app\models\extend\Video;
use app\models\search\VideoSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\extend\VideoUser;
use app\util\CommonUtil;

class VideoController extends \app\util\BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create', 'index', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'index', 'update', 'delete'],
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

    public function actionIndex() {
        $searchModel = new VideoSearch();
        $searchModel->status = 1;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 12;
        $dataProvider->sort = ['defaultOrder' => ['createtime' => SORT_DESC]];
        $searchModel->tag = explode(',', trim($searchModel->tag, ','));

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        $model = $this->findModel($id);
        if($model->status<0) {
            throw new NotFoundHttpException('该作品已被删除');
        }
        $model->updateCounters(['views' => 1]);

        $otherWorks = Video::find()->where(['uid' => $model->uid, 'status' => 1])->andWhere(['<>', 'id', $id])->orderBy('id desc')->limit(8)->all();
        $members = VideoUser::findAll(['video_id' => $id, 'status' => 0]);

        return $this->render('view', [
                    'model' => $model,
                    'otherWorks' => $otherWorks,
                    'members' => $members,
        ]);
    }

    public function actionCreate() {
        $model = new Video();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \app\models\extend\PlanUser::turnToVideoUser($model->plan_id, $model->id);
            //Yii::$app->db->createCommand('insert into tbl_video_user (uid, video_id, createtime) values (:uid, :video_id, :createtime)', [':uid' => $model->uid, ':video_id' => $model->id, ':createtime' => time()])->execute();
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['video-user/index', 'video_id' => $model->id]);
        } else {
            //$model->logo = './image/blank_img.jpg';
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->tag = explode(',', trim($model->tag, ','));

            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDelete($id) {
        $this->findModel($id)->updateAttributes(['status' => -1]);

        return $this->redirect(['video/my']);
    }

    protected function findModel($id) {
        if (($model = Video::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDing($id) {
        $model = $this->findModel($id);
        $model->updateCounters(['support' => 1]);

        $this->sendRes(true, '', $model->support);
    }

    public function actionCai() {
        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        $model->updateCounters(['oppose' => 1]);

        $this->sendRes(true, '', $model->oppose);
    }

    public function actionMy() {
        $searchModel = new VideoSearch();
        $searchModel->uid = Yii::$app->user->id;
        $searchModel->status = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['createtime' => SORT_DESC]];

        return $this->render('my', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}
