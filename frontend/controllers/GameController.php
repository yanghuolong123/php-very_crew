<?php

namespace app\controllers;

use Yii;
use app\models\extend\Games;
use app\models\extend\GameVideo;
use app\models\search\GamesSearch;
use app\models\search\GameVideoSearch;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use app\util\Constant;

class GameController extends \app\util\BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['email-vote'],
                'rules' => [
                    [
                        'actions' => ['email-vote'],
                        'allow' => true,
                        'roles' => ['?'],
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

    public function actionView($id, $sorting = 'id') {
        $type = Yii::$app->request->get("type");
        $view = "view";
        if (!empty($type) && $type == "activity") {
            $view = $type;
        }
        $model = $this->findModel($id);
        $query = GameVideoSearch::find();
        $query->andWhere(['game_id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->pagination->pageSize = 12;
        $dataProvider->sort = ['defaultOrder' => [$sorting => SORT_DESC]];

        return $this->render($view, [
                    'model' => $model,
                    'dataProvider' => $dataProvider,
                    'sort' => $sorting,
        ]);
    }

    public function actionAjaxVote() {
        $id = intval(Yii::$app->request->post('id'));
        if (Yii::$app->user->isGuest) {
            $this->sendRes(false, '', $id);
        }

        $collection = Yii::$app->mongodb->getCollection('game_vote_record');
        if (!empty($collection->findOne(['game_video_id' => $id, 'uid' => Yii::$app->user->id]))) {
            $this->sendRes(true, '', 0);
        }

        $model = GameVideo::findOne($id);
        $model->updateCounters(['votes' => 1]);
        $collection->insert(['game_video_id' => $model->id, 'uid' => Yii::$app->user->id, 'time' => DATETIME]);

        $this->sendRes(true, '', $model->votes);
    }

    public function actionResult($id) {
        $model = $this->findModel($id);

        return $this->render('result', [
                    'model' => $model,
        ]);
    }

    public function actionAjaxMail() {
        $email = Yii::$app->request->post('email');
        $voteId = Yii::$app->request->post('voteId');
        Yii::$app->redis->LPUSH(Constant::VoteEmailList, json_encode(['email' => $email, 'voteId' => $voteId]));
        $this->sendRes();
    }

    public function actionEmailVote($email, $gameVideoId) {
        $collection = Yii::$app->mongodb->getCollection('game_vote_record');
        $resutl = 0;
        if (empty($collection->findOne(['game_video_id' => intval($gameVideoId), 'email' => $email]))) {
            $model = GameVideo::findOne($gameVideoId);
            if (empty($model)) {
                throw new NotFoundHttpException("没有此参赛作品");
            }
            $model->updateCounters(['votes' => 1]);
            $collection = Yii::$app->mongodb->getCollection('game_vote_record');
            $collection->insert(['game_video_id' => $model->id, 'email' => $email, 'time' => DATETIME]);
            $resutl = 1;
        }


        return $this->render('emailVote', [
                    'resutl' => $resutl,
        ]);
    }

}
