<?php

namespace app\controllers;

use Yii;
use app\models\extend\Comment;
use app\models\extend\User;
use app\models\extend\Video;
use \yii\data\Pagination;
use app\util\Constant;
use yii\web\NotFoundHttpException;
use app\models\extend\ForumThread;
use yii\helpers\Html;

class CommentController extends \app\components\ext\BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create', 'my-list'],
                'rules' => [
                    [
                        'actions' => ['create', 'my-list'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate() {
        $model = new Comment();

        $model->load(Yii::$app->request->post());
        if ($content = strstr($model->content, '[/quote]')) {
            $model->content = trim(ltrim($content, '[/quote]'));
        }
        if ($model->save()) {
            $model->createtime = date('Y-m-d H:i:s', $model->createtime);
            $arr = \yii\helpers\ArrayHelper::toArray($model);
            $arr['avatar'] = User::getInfo($model->uid)->avatar;
            $arr['nickname'] = User::getInfo($model->uid)->nickname;
            $parent = Comment::findOne($model->parent_id);
            if ($parent) {
                $parent->createtime = date('Y-m-d H:i:s', $parent->createtime);
                $arr['parent'] = $parent->toArray();
                $arr['parent_nickname'] = User::getInfo($parent['uid'])->nickname;
                Yii::$app->db->createCommand('update tbl_comment set reply_id=:reply_id where id=' . $model->id, [':reply_id' => $parent->uid])->execute();
            }

            switch ($model->type) {
                case 1:
                    if (!empty($model->vid)) {
                        $videoModel = Video::findOne($model->vid);
                        $videoModel->updateCounters(['comments' => 1]);
                    }
                    break;
                case 2:
                    Yii::$app->redis->HINCRBY(Constant::UserMsg, Constant::UserMsg . (empty($parent->id) ? $model->vid : $parent->uid), 1);
                    break;
                case 3:
                    Yii::$app->redis->HINCRBY(Constant::UserPrivateMsg, Constant::UserPrivateMsg . (empty($parent->id) ? $model->vid : $parent->uid), 1);
                    break;
                case 5:
                    $forumThread = ForumThread::findOne($model->vid);
                    $forumThread->updateCounters(['posts' => 1]);
                    $content = Yii::$app->user->identity->nickname . ' 回复了您的帖子: ' . Html::a($forumThread->title, ['forum-thread/view', 'id' => $forumThread->id]) . ' 请你查看。';
                    Comment::sendNews($forumThread->user_id, $content);
                    break;
            }

            $this->sendRes(true, 'success', $arr);
        }

        $this->sendRes(false);
    }

    public function actionMyList($type) {
        switch ($type) {
            case 2:
                Yii::$app->redis->HDEL(Constant::UserMsg, Constant::UserMsg . Yii::$app->user->id);
                break;
            case 3:
                Yii::$app->redis->HDEL(Constant::UserPrivateMsg, Constant::UserPrivateMsg . Yii::$app->user->id);
                break;
            case 4:
                Yii::$app->redis->HDEL(Constant::UserNews, Constant::UserNews . Yii::$app->user->id);
                break;
        }


        $query = Comment::find()->where(['or', ['type' => $type, 'vid' => Yii::$app->user->id], ['type' => $type, 'reply_id' => Yii::$app->user->id]]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->defaultPageSize = 5;
        $models = $query->offset($pages->offset)->limit($pages->limit)->orderby('createtime desc')->all();

        return $this->render('myList', [
                    'commentList' => $models,
                    'pages' => $pages,
                    'type' => $type,
        ]);
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

    protected function findModel($id) {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
