<?php

namespace app\controllers;

use Yii;
use app\models\extend\Plan;
use app\models\extend\PlanUser;
use app\models\search\PlanSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\extend\User;
use app\models\extend\MetaData;

class PlanController extends \app\util\BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['update', 'index', 'create', 'delete'],
                'rules' => [
                    [
                        'actions' => ['update', 'index', 'create', 'delete'],
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
        $searchModel = new PlanSearch();
        $searchModel->status = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;
        $searchModel->plan_role = explode(',', trim($searchModel->plan_role, ','));
        $searchModel->plan_skill = explode(',', trim($searchModel->plan_skill, ','));

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'planUsers' => PlanUser::findAll(['plan_id' => $id, 'status' => 0]),
        ]);
    }

    public function actionCreate() {
        $model = new Plan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->db->createCommand('insert into tbl_plan_user (uid, plan_id, createtime) values (:uid, :plan_id, :createtime)', [':uid' => $model->uid, ':plan_id' => $model->id, ':createtime' => time()])->execute();

            //return $this->redirect(['join', 'plan_id' => $model->id]);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
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
            $model->plan_role = explode(',', trim($model->plan_role, ','));
            $model->plan_skill = explode(',', trim($model->plan_skill, ','));

            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDelete($id) {
        $this->findModel($id)->updateAttributes(['status' => 0]);

        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        if (($model = Plan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionJoin($plan_id) {
        $model = new PlanUser();

        $planUser = PlanUser::findOne(['plan_id' => $plan_id, 'uid' => Yii::$app->user->id]);
        if (!empty($planUser)) {
            Yii::$app->session->setFlash('hasJoin', $planUser->status);
        }

        $model->type = 1;
        if ($model->load(Yii::$app->request->post())) {
            $model->role_name = MetaData::getVal($model->role);

            if ($model->save()) {
                return $this->redirect(['info', 'info_view' => 'join_info', 'data' => $model->plan_id]);
            }
        }

        return $this->render('join', [
                    'model' => $model,
                    'plan_id' => $plan_id,
        ]);
    }

//    public function actionUser($plan_id) {
//        $planModel = Plan::findOne($plan_id);
//        $planUsers = PlanUser::find()->where(['plan_id' => $plan_id])->orderBy('createtime desc')->all();
//
//        return $this->render('user', [
//                    'planModel' => $planModel,
//                    'planUsers' => $planUsers,
//        ]);
//    }

    public function actionAuditUser($id, $status) {
        $model = PlanUser::findOne([$id]);
        $model->updateAttributes(['status' => $status]);

        return $this->redirect(['user', 'plan_id' => $model->plan_id]);
    }

    public function actionMy() {
        $searchModel = new PlanSearch();
        $searchModel->uid = Yii::$app->user->id;
        $searchModel->status = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['createtime' => SORT_DESC]];

        return $this->render('my', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionInvitation($uid) {
        $model = new PlanUser();

        $model->uid = $uid;
        $model->type = 2;
        if ($model->load(Yii::$app->request->post())) {

            $planUser = PlanUser::findOne(['plan_id' => $model->plan_id, 'uid' => $model->uid]);
            if (!empty($planUser)) {
                Yii::$app->session->setFlash('hasJoin', $planUser->status);
            }

            if (empty($planUser) && $model->save()) {
                $plan = Plan::findOne($model->plan_id);
                $comment = new \app\models\extend\Comment();
                $comment->type = 4;
                $comment->uid = Yii::$app->user->id;
                $comment->vid = $model->uid;
                $comment->content = Yii::$app->user->identity->nickname . ' 将您加入计划:' . $plan->title . ' 备选人员，建议您主动联系他沟通合作事宜。';
                $comment->save();

                Yii::$app->redis->incr('user_news_' . $model->uid);
                return $this->redirect(['view', 'id' => $model->plan_id]);
            }
        }

        return $this->render('invitation', [
                    'model' => $model,
        ]);
    }

}
