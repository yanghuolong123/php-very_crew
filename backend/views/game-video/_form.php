<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\extend\GameVideo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="game-video-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'game_id')->textInput() ?>

    <?php // $form->field($model, 'video_id')->textInput() ?>

    <?php // $form->field($model, 'user_id')->textInput() ?>

    <?php // $form->field($model, 'votes')->textInput() ?>

    <?=  $form->field($model, 'score')->textInput() ?>

    <?= $form->field($model, 'remark')->textarea() ?>

    <?php // $form->field($model, 'createtime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
