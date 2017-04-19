<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\extend\MetaData;

/* @var $this yii\web\View */
/* @var $model app\models\extend\MetaData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="meta-data-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'group_key')->dropDownList(MetaData::getGroupKeyArr()) ?>

    <?= $form->field($model, 'mkey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput(['value'=>  empty($model->sort)? 0 : $model->sort]) ?>
    <?= $form->field($model, 'status')->dropDownList([1=>'启用',0=>'禁用']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
