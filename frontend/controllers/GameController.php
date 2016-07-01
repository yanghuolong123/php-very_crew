<?php

namespace app\controllers;

class GameController extends \yii\web\Controller {

    public function actionIndex() {
        $model = new \app\models\extend\Video();
        return $this->render('index', [
            'model' => $model,
        ]);
    }

}
