<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\extend\GamePrize */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="game-prize-form">

    <?php $form = ActiveForm::begin(); ?>    

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'instruction')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'win_ids')->textInput(['maxlength' => true]) ?>
 
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
