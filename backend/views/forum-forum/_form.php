<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\extend\ForumForum;

/* @var $this yii\web\View */
/* @var $model app\models\extend\ForumForum */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="forum-forum-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(ForumForum::getStatusArr()) ?>

    <?= $form->field($model, 'desc')->textarea() ?>
    <?php // $form->field($model, 'create_time')->textInput() ?>

    <?php // $form->field($model, 'update_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
