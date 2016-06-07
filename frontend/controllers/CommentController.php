<?php

namespace app\controllers;

use Yii;
use app\models\extend\Comment;
use app\models\extend\User;
use app\models\extend\Video;
use \yii\data\Pagination;

class CommentController extends \app\util\BaseController {

    public function actionCreate() {
        $model = new Comment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->createtime = date('Y-m-d H:i:s', $model->createtime);
            $arr = \yii\helpers\ArrayHelper::toArray($model);
            $arr['avatar'] = User::getInfo($model->uid)->avatar;
            $arr['nickname'] = User::getInfo($model->uid)->nickname;

            switch ($model->type) {
                case 1:
                    if (!empty($model->vid)) {
                        $videoModel = Video::findOne($model->vid);
                        $videoModel->updateCounters(['comments' => 1]);
                    }
                    break;
                case 2:
                    $redis = Yii::$app->redis;
                    if ($model->status == 1) {
                        $redis->incr('user_msg_' . $model->vid);
                    } elseif ($model->status == 2) {
                        $redis->incr('user_private_msg_' . $model->vid);
                    }
                    break;
            }

            $this->sendRes(true, 'success', $arr);
        }

        $this->sendRes(false);
    }

    public function actionMyMsg() {
        Yii::$app->redis->del('user_msg_'.Yii::$app->user->id);

        $query = Comment::find()->where(['type' => 2, 'vid' => Yii::$app->user->id, 'status' => 1]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->defaultPageSize = 5;
        $models = $query->offset($pages->offset)->limit($pages->limit)->orderby('createtime desc')->all();

        return $this->render('myMsg', [
                    'commentList' => $models,
                    'pages' => $pages,
        ]);
    }

    public function actionMyPrivateMsg() {
        Yii::$app->redis->del('user_private_msg_'.Yii::$app->user->id);
        
        $query = Comment::find()->where(['type' => 2, 'vid' => Yii::$app->user->id, 'status' => 2]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->defaultPageSize = 5;
        $models = $query->offset($pages->offset)->limit($pages->limit)->orderby('createtime desc')->all();

        return $this->render('myPrivateMsg', [
                    'commentList' => $models,
                    'pages' => $pages,
        ]);
    }

}
