<?php

namespace app\controllers;

use app\models\extend\ForumPost;
use Yii;
use app\models\extend\User;

class ForumPostController extends \app\util\BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate() {
        $model = new ForumPost();
        $model->load(Yii::$app->request->post());
        if ($content = strstr($model->content, '[/quote]')) {
            $model->content = trim(ltrim($content, '[/quote]'));
        }

        if ($model->save()) {
            $model->createtime = date('Y-m-d H:i:s', $model->createtime);
            $arr = \yii\helpers\ArrayHelper::toArray($model);
            $arr['avatar'] = User::getInfo($model->user_id)->avatar;
            $arr['nickname'] = User::getInfo($model->user_id)->nickname;
            $parent = ForumPost::findOne($model->parent_id);
            if ($parent) {
                $parent->createtime = date('Y-m-d H:i:s', $parent->createtime);
                $arr['parent'] = $parent->toArray();
                $arr['parent_nickname'] = User::getInfo($parent['uid'])->nickname;
            }

            $this->sendRes(true, 'success', $arr);
        }

        $this->sendRes(false);
    }

}
