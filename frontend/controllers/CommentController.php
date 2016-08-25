<?php

namespace app\controllers;

use Yii;
use app\models\extend\Comment;
use app\models\extend\User;
use app\models\extend\Video;
use \yii\data\Pagination;
use app\util\Constant;

class CommentController extends \app\util\BaseController {

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
            }

            switch ($model->type) {
                case 1:
                    if (!empty($model->vid)) {
                        $videoModel = Video::findOne($model->vid);
                        $videoModel->updateCounters(['comments' => 1]);
                    }
                    break;
                case 2:
                    Yii::$app->redis->INCR(Constant::UserMsg . $model->vid);
                    break;
                case 3:
                    Yii::$app->redis->INCR(Constant::UserPrivateMsg . $model->vid);
                    break;
            }

            $this->sendRes(true, 'success', $arr);
        }

        $this->sendRes(false);
    }

    public function actionMyList($type) {
        switch ($type) {
            case 2:
                Yii::$app->redis->del(Constant::UserMsg . Yii::$app->user->id);
                break;
            case 3:
                Yii::$app->redis->del(Constant::UserPrivateMsg . Yii::$app->user->id);
                break;
            case 4:
                Yii::$app->redis->del(Constant::UserNews . Yii::$app->user->id);
                break;
        }


        $query = Comment::find()->where(['type' => $type, 'vid' => Yii::$app->user->id]);
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

    protected function findModel($id) {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
