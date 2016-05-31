<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerJsFile('@web/js/main.js',['depends'=>['app\assets\AppAsset']]);

/* @var $this yii\web\View */
/* @var $model app\models\extend\Advertisement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="advertisement-form">

    <?php $form = ActiveForm::begin([
        'id' => 'advertisement-form',
        'fieldClass' => 'app\util\ExtActiveField',
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->imgInput() ?>

    <?= $form->field($model, 'sort')->textInput(['value'=>0]) ?>

    <?= $form->field($model, 'status')->dropDownList([1=>'启用',0=>'关闭']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
