<?php

namespace app\util;

use yii\helpers\Html;

class ExtActiveField extends \yii\widgets\ActiveField {

    public function imgInput($options = []) {
        // https://github.com/yiisoft/yii2/pull/795
        if ($this->inputOptions !== ['class' => 'form-control']) {
            $options = array_merge($this->inputOptions, $options);
        }
        // https://github.com/yiisoft/yii2/issues/8779
        if (!isset($this->form->options['enctype'])) {
            $this->form->options['enctype'] = 'multipart/form-data';
        }
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = '<a href="#" class="thumbnail" title="点击上传图片"><img src="'.$this->model->{$this->attribute}.'" alt="点击上传图片"></a>' . Html::activeHiddenInput($this->model, $this->attribute, $options);

        return $this;
    }
    
    public function uploadifyInput($options = []) {
        // https://github.com/yiisoft/yii2/pull/795
        if ($this->inputOptions !== ['class' => 'form-control']) {
            $options = array_merge($this->inputOptions, $options);
        }
        // https://github.com/yiisoft/yii2/issues/8779
        if (!isset($this->form->options['enctype'])) {
            $this->form->options['enctype'] = 'multipart/form-data';
        }
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = '<input id="file_upload" name="file_upload" type="file" multiple="true">' . Html::activeHiddenInput($this->model, $this->attribute, $options).'<div id="queue"></div>';

        return $this;
    }

}
