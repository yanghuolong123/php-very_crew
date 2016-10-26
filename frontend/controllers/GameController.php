<?php

namespace app\controllers;

use Yii;
use app\models\extend\Games;
use app\models\extend\GameVideo;
use app\models\search\GamesSearch;
use yii\data\ActiveDataProvider;

class GameController extends \app\util\BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['view', 'index', 'ajax-vote'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'ajax-vote'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    protected function findModel($id) {
        if (($model = Games::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionIndex() {
        $searchModel = new GamesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        $model = $this->findModel($id);
        $query = GameVideo::find();
        $query->andWhere(['game_id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->pagination->pageSize = 12;
        $dataProvider->sort = ['defaultOrder' => ['createtime' => SORT_DESC]];

        return $this->render('view', [
                    'model' => $model,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAjaxVote() {
        $id = Yii::$app->request->post('id');
        $model = GameVideo::findOne($id);
        $model->updateCounters(['votes' => 1]);
        $collection = Yii::$app->mongodb->getCollection('game_vote_record');
        $collection->insert(['game_video_id' => $model->id, 'uid' => Yii::$app->user->id]);

        $this->sendRes(true, '', $model->votes);
    }

    public function actionResult($id) {
        $model = $this->findModel($id);

        return $this->render('result', [
                    'model' => $model,
        ]);
    }

}
