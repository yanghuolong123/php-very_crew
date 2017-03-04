<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\extend\ForumThread */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="forum-thread-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fid')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'views')->textInput() ?>

    <?= $form->field($model, 'posts')->textInput() ?>

    <?= $form->field($model, 'recommand')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'lastpost')->textInput() ?>

    <?= $form->field($model, 'lastposter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
