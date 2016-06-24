<?php

namespace app\components\crop;

use yii\base\Widget;
use app\components\crop\CropAsset;

class CropWidget extends Widget {

    public $form;
    public $model;
    public $title;
    public $attribute;

    public function run() {
        $view = $this->getView();
        CropAsset::register($view);
        
        return $this->render('crop', [
                    'form' => $this->form,
                    'model' => $this->model,
                    'title' => $this->title,
                    'attribute' => $this->attribute,
        ]);
    }

}
