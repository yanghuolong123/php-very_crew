<?php

namespace app\components\district;

use Yii;
use yii\base\Widget;

class DistrictWidget extends Widget {

    public $form;
    public $model;
    public $title;
    public $level = 3;

    public function run() {
        return $this->render('district', [
                    'form' => $this->form,
                    'model' => $this->model,
                    'title' => $this->title,
                    'level' => $this->level,
        ]);
    }

}
