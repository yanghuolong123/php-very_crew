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
use yii\helpers\Url;

class VideoController extends \app\components\ext\BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete'],
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
        $searchModel->status = [1, 2];

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

        $otherWorks = Video::find()->where(['uid' => $model->uid])->andWhere(['in', 'status', [1, 2]])->andWhere(['<>', 'id', $id])->orderBy('id desc')->limit(8)->all();
        $members = VideoUser::findAll(['video_id' => $id, 'status' => 0]);
        $rewardList = \app\models\extend\Order::findAll(['product_id'=>$id, 'status'=>1]);

        return $this->render('view', [
                    'model' => $model,
                    'otherWorks' => $otherWorks,
                    'members' => $members,
                    'rewardList' => $rewardList,
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

    public function actionReward() {
        $videoId = Yii::$app->request->post('videoId');
        $amount = Yii::$app->request->post('amount');
        $msg = Yii::$app->request->post('msg');
        $payType = Yii::$app->request->post('payType');

        $order = \app\models\extend\Order::generateOrder($amount, $videoId, 1, $payType, $msg);

        $notify = new \app\modules\weixin\components\wxpay\NativePay();
        $input = new \WxPayUnifiedOrder();
        $input->SetBody("非常剧组1");
        $input->SetAttach("非常剧组2");
        $input->SetOut_trade_no($order->orderno);
        $input->SetTotal_fee($order->amount * 100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("非常剧组3");
        $input->SetNotify_url(Url::to(['/weixin/pay/notify'], TRUE));
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id($order->product_id);
        $result = $notify->GetPayUrl($input);
        if (!isset($result["code_url"])) {
            $this->sendRes(false, 'error get pay weixin qrcode');
        }

        $qrcode = $result["code_url"];
        $arr['qrcode'] = Url::to(['/weixin/pay/qrcode', 'data'=>urlencode($qrcode)]);
        $arr['orderId'] = $order->id;

        $this->sendRes(true, '', $arr);
    }

}
