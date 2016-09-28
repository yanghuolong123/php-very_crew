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
        $this->parts['{input}'] = '<a href="#" class="thumbnail" title="点击上传图片"><img src="' . $this->model->{$this->attribute} . '" alt="点击上传图片"></a>' . Html::activeHiddenInput($this->model, $this->attribute, $options);

        return $this;
    }

    public function uploadImg($options = []) {
        // https://github.com/yiisoft/yii2/pull/795
        if ($this->inputOptions !== ['class' => 'form-control']) {
            $options = array_merge($this->inputOptions, $options);
        }
        // https://github.com/yiisoft/yii2/issues/8779
        if (!isset($this->form->options['enctype'])) {
            $this->form->options['enctype'] = 'multipart/form-data';
        }
        $this->adjustLabelFor($options);
        $src = isset($options['width']) && isset($options['height']) && !empty($this->model->{$this->attribute}) ? CommonUtil::cropImgLink($this->model->{$this->attribute}, $options['width'], $options['height']) : $this->model->{$this->attribute};
        $style = $this->model->{$this->attribute} ? '' : ' style="display:none;" ';
        $this->parts['{input}'] = '<div class="thumbnail"><img src="' . $src . '"' . $style . ' ></div>';
        $this->parts['{input}'] .= '<button type="button" class="btn btn-primary upload_img">上传图像</button> ';
        $this->parts['{input}'] .= Html::activeHiddenInput($this->model, $this->attribute, $options);
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
        $this->parts['{input}'] = '<input id="file_upload" name="file_upload" type="file" multiple="true">' . Html::activeHiddenInput($this->model, $this->attribute, $options) . '<div id="queue"></div>';

        return $this;
    }

    public function cropImgInput($options = []) {
        // https://github.com/yiisoft/yii2/pull/795
        if ($this->inputOptions !== ['class' => 'form-control']) {
            $options = array_merge($this->inputOptions, $options);
        }
        // https://github.com/yiisoft/yii2/issues/8779
        if (!isset($this->form->options['enctype'])) {
            $this->form->options['enctype'] = 'multipart/form-data';
        }
        $this->adjustLabelFor($options);

        $this->parts['{input}'] = '<a href="#" class="crop_thumbnail" title="请先上传图像"><img class="cropbox" src="' . $this->model->{$this->attribute} . '" alt="请先上传图像"></a>';
        $this->parts['{input}'] .= '<input type="hidden" id="x" name="x" /><input type="hidden" id="y" name="y" /><input type="hidden" id="w" name="w" /><input type="hidden" id="h" name="h" />';
        $this->parts['{input}'] .= '<button type="button" class="btn btn-primary upload_img">上传图像</button> ';
        $this->parts['{input}'] .= '&nbsp;<button type="button" id="cut_img" class="btn btn-success">裁剪图像</button>';

        return $this;
    }

}
