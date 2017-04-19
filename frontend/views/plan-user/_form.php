<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\extend\PlanUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plan-user-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?php // $form->field($model, 'uid')->textInput() ?>

    <?php // $form->field($model, 'plan_id')->textInput() ?>

    <?= $form->field($model, 'role_name')->textInput() ?>

    <?php // $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'instruction')->textarea()->label('备注') ?>

    <?php // $form->field($model, 'createtime')->textInput() ?>

    <?php // $form->field($model, 'updatetime')->textInput() ?>

    <div class="form-group">
        <div class="col-sm-1 col-md-offset-2">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
