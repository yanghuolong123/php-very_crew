<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\extend\PlanUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plan-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'uid')->textInput() ?>

    <?php // $form->field($model, 'plan_id')->textInput() ?>

    <?= $form->field($model, 'role')->textInput() ?>

    <?php // $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'createtime')->textInput() ?>

    <?= $form->field($model, 'updatetime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
