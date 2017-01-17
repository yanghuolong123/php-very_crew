<?php

namespace app\components\timesection;

use yii\base\Widget;

class TimeSectionWidget extends Widget {

    public $model;
    public $form;

    public function run() {
        return $this->render("timesection", [
                    'model' => $this->model,
                    'form' => $this->form,
        ]);
    }

}
