<?php

namespace app\controllers;

use app\models\extend\Distrinct;

class DistrictController extends \app\util\BaseController {
    
    public $enableCsrfValidation = false;

    public function actionIndex($pid) {
        $data = Distrinct::getDistrictList($pid);

        foreach ($data as $id => $name) {
            echo \yii\helpers\Html::tag('option', $name, ['value' => $id]);
        }
    }

}
