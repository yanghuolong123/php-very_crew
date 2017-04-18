<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\GameApplySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="game-apply-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'game_id') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'summary') ?>

    <?php // echo $form->field($model, 'join_num') ?>

    <?php // echo $form->field($model, 'len_minute') ?>

    <?php // echo $form->field($model, 'len_second') ?>

    <?php // echo $form->field($model, 'condition') ?>

    <?php // echo $form->field($model, 'ability') ?>

    <?php // echo $form->field($model, 'advantage') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
