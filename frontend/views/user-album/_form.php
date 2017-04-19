<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerJsFile('@web/js/upload.js',['depends'=>['app\assets\AppAsset']]);

?>

<div class="user-album-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldClass' => 'app\util\ExtActiveField',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->imgInput() ?>

    <?= $form->field($model, 'instruction')->textarea() ?>

    <div class="form-group">
        <div class="col-sm-1 col-md-offset-2">
        <?= Html::submitButton($model->isNewRecord ? '上传' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
