<?php

namespace app\controllers;

use Yii;
use app\models\extend\ForumThread;
use app\models\search\ForumThreadSearch;
use yii\web\NotFoundHttpException;
use app\models\extend\ForumForum;
use yii\filters\VerbFilter;

class ForumThreadController extends \app\components\ext\BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['update', 'my', 'delete', 'create'],
                'rules' => [
                    [
                        'actions' => ['delete', 'my', 'update', 'create'],
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

    public function actions() {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    //"imageUrlPrefix" => "http://www.baidu.com", //图片访问路径前缀
                    "imagePathFormat" => "/uploads/ueditor/{yyyy}{mm}{dd}/{time}{rand:6}" //上传保存路径
                ],
            ]
        ];
    }

    public function actionIndex($fid) {
        if (empty($fid)) {
            throw new NotFoundHttpException('parameter error');
        }

        $searchModel = new ForumThreadSearch();
        $searchModel->fid = $fid;
        $searchModel->status = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 12;
        $dataProvider->sort = ['defaultOrder' => ['id' => SORT_DESC]];
        $forums = ForumForum::find()->where(['status' => 0])->orderBy('sort asc')->all();
        $forum = ForumForum::findOne($fid);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'forums' => $forums,
                    'forum' => $forum,
        ]);
    }

    public function actionView($id) {
        $model = $this->findModel($id);
        if ($model->status < 0) {
            throw new NotFoundHttpException('该帖子已被删除');
        }
        $model->updateCounters(['views' => 1]);

        $forums = ForumForum::find()->where(['status' => 0])->orderBy('sort asc')->all();

        return $this->render('view', [
                    'model' => $model,
                    'forums' => $forums,
        ]);
    }

    public function actionCreate() {
        $model = new ForumThread();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            ForumForum::findOne($model->fid)->updateCounters(['threads' => 1]);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $fid = Yii::$app->request->get('fid');
            if (!empty($fid)) {
                $model->fid = $fid;
            }
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
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->updateAttributes(['status' => -1]);
        ForumForum::findOne($model->fid)->updateCounters(['threads' => 1]);

        return $this->redirect(['forum-thread/index', 'fid' => $model->fid]);
    }

    protected function findModel($id) {
        if (($model = ForumThread::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionMy() {
        $searchModel = new ForumThreadSearch();
        $searchModel->status = 0;
        $searchModel->user_id = Yii::$app->user->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['recommand' => SORT_DESC, 'recommand_time' => SORT_DESC]];
        $dataProvider->pagination->pageSize = 12;

        return $this->render('my', [
                    'dataProvider' => $dataProvider,
        ]);
    }

}
