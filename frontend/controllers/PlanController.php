<?php

namespace app\controllers;

use Yii;
use app\models\extend\Plan;
use app\models\extend\PlanUser;
use app\models\native\PlanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class PlanController extends Controller {

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
        $searchModel->uid = Yii::$app->user->id;
        $searchModel->status = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'planUsers' => PlanUser::findAll(['plan_id' => $id, 'status' => 1]),
        ]);
    }

    public function actionCreate() {
        $model = new Plan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['join', 'plan_id' => $model->id]);
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
            $model->video_ids = explode(',', trim($model->video_ids, ','));

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
        $plan = Plan::findOne($plan_id);
        if ($plan->uid == Yii::$app->user->id) {
            $model->type = 1;
            $model->status = 1;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->plan_id]);
        } else {
            return $this->render('join', [
                        'model' => $model,
                        'plan_id' => $plan_id,
            ]);
        }
    }

    public function actionUser($plan_id) {
        $planModel = Plan::findOne($plan_id);
        $planUsers = PlanUser::find()->where(['plan_id' => $plan_id])->orderBy('createtime desc')->all();

        return $this->render('user', [
                    'planModel' => $planModel,
                    'planUsers' => $planUsers,
        ]);
    }

    public function actionAuditUser($id, $status) {
        $model = PlanUser::findOne([$id]);
        $model->updateAttributes(['status' => $status]);

        return $this->redirect(['user', 'plan_id' => $model->plan_id]);
    }

}
