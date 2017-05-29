<?php

namespace app\controllers;

use Yii;
use app\models\extend\Video;
use app\models\search\VideoSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\extend\VideoUser;
use app\models\extend\Games;
use app\models\extend\GameVideo;

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
        $searchModel->status = [1,2];

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
        if ($model->status == -1) {
            throw new NotFoundHttpException('该作品已被删除');
        }
        $model->updateCounters(['views' => 1]);

        $otherWorks = Video::find()->where(['uid' => $model->uid])->andWhere(['in', 'status', [1,2]])->andWhere(['<>', 'id', $id])->orderBy('id desc')->limit(8)->all();
        $members = VideoUser::findAll(['video_id' => $id, 'status' => 0]);
        var_dump(\yii\helpers\ArrayHelper::map(\yii\helpers\ArrayHelper::toArray($members), "id", "uid"));
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
            $gameId = Yii::$app->request->post('game_id');
            if (!empty($gameId)) {
                Yii::$app->db->createCommand('insert into tbl_game_video (game_id, video_id, user_id, createtime) values (:game_id, :video_id, :user_id, :createtime)', [':game_id' => $gameId, ':video_id' => $model->id, ':user_id' => $model->uid, ':createtime' => time()])->execute();
                Games::updateAllCounters(['number' => 1], ['id' => $gameId]);
                $model->updateAttributes(['status' => -2]);
            }
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
        GameVideo::updateAll(['status' => -1], ['video_id' => $id]);


        return $this->redirect(['video/my']);
    }

    protected function findModel($id) {
        if (($model = Video::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDing() {
        $id = Yii::$app->request->post('id');
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
        $searchModel->status = [1, 2];
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['createtime' => SORT_DESC]];

        return $this->render('my', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}
