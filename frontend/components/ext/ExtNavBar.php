<?php

namespace app\components\ext;

use yii\bootstrap\Html;

class ExtNavBar extends \yii\bootstrap\NavBar {

    protected function renderToggleButton() {
        $bar = Html::tag('b', '', ['class' => 'caret']);
        $screenReader = "<span >{$this->screenReaderToggleText}</span>";

        return Html::button("{$screenReader}\n{$bar}", [
                    'class' => 'navbar-toggle',
                    'data-toggle' => 'collapse',
                    'data-target' => "#{$this->containerOptions['id']}",
        ]);
    }

}
