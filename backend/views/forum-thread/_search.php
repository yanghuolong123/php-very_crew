<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\ForumThreadSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="forum-thread-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fid') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'content') ?>

    <?= $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'views') ?>

    <?php // echo $form->field($model, 'posts') ?>

    <?php // echo $form->field($model, 'recommand') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'lastpost') ?>

    <?php // echo $form->field($model, 'lastposter') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
