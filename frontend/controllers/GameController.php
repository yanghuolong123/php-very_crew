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
use app\models\extend\GameApply;
use app\models\extend\GamePrize;

class GameController extends \app\util\BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['email-vote', 'apply'],
                'rules' => [
                    [
                        'actions' => ['email-vote'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['apply'],
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
        $dataProvider->sort = ['defaultOrder' => ['sort' => SORT_DESC]];

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
        $query->andWhere(['game_id' => $id, 'status' => 0]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->pagination->pageSize = 120;
        $dataProvider->sort = ['defaultOrder' => [$sorting => SORT_DESC]];

        return $this->render($view, [
                    'model' => $model,
                    'dataProvider' => $dataProvider,
                    'sort' => $sorting,
        ]);
    }

    public function actionAjaxVote() {
        $videoId = intval(Yii::$app->request->post('videoId'));
        $weixin = new \app\modules\weixin\models\Weixin();
        $res = $weixin->getQrCodeImg($videoId, 24 * 3600);
        if ($res == 'error') {
            $this->sendRes(false, '网路错误');
        }
        $this->sendRes(true, 'success', $res);
//        $id = intval(Yii::$app->request->post('id'));
//        if (Yii::$app->user->isGuest) {
//            $this->sendRes(false, '', $id);
//        }
//
//        $collection = Yii::$app->mongodb->getCollection('game_vote_record');
//        if (!empty($collection->findOne(['game_video_id' => $id, 'uid' => Yii::$app->user->id]))) {
//            $this->sendRes(true, '', 0);
//        }
//
//        $model = GameVideo::findOne($id);
//        $model->updateCounters(['votes' => 1]);
//        $collection->insert(['game_video_id' => $model->id, 'uid' => Yii::$app->user->id, 'time' => DATETIME]);
//
//        $this->sendRes(true, '', $model->votes);
    }

    public function actionResult($id) {
        $model = $this->findModel($id);
        $prizes = GamePrize::findAll(['game_id' => $model->id]);

        return $this->render('result', [
                    'model' => $model,
                    'prizes' => $prizes,
        ]);
    }

    /**
     * @deprecated since version number
     */
    public function actionAjaxMail() {
        $email = Yii::$app->request->post('email');
        $voteId = Yii::$app->request->post('voteId');
        Yii::$app->redis->LPUSH(Constant::VoteEmailList, json_encode(['email' => $email, 'voteId' => $voteId]));
        $this->sendRes();
    }

    /**
     * @deprecated since version number
     * 
     * @param type $email
     * @param type $gameVideoId
     * @return type
     * @throws NotFoundHttpException
     */
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

    public function actionApply($game_id) {
        $apply = GameApply::findOne(['game_id' => $game_id, 'user_id' => Yii::$app->user->id]);
        if (!empty($apply)) {
            Yii::$app->session->setFlash('hasApply');
        }

        $game = Games::findOne($game_id);
        if (empty($game)) {
            throw new NotFoundHttpException('此大赛不存在');
        }

        $model = new GameApply();
        $model->game_id = $game_id;
        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['apply', 'game_id' => $game_id]);
        } else {
            $model->username = Yii::$app->user->identity->nickname;
            return $this->render('apply', [
                        'model' => $model,
                        'game' => $game,
            ]);
        }
    }

}
