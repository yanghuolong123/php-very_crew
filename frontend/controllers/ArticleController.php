<?php

namespace app\controllers;

use app\models\extend\Article;
use yii\web\NotFoundHttpException;

class ArticleController extends \app\util\BaseController {

    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id) {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
