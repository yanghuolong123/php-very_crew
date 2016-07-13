<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\extend\Video;
use app\models\extend\MetaData; 
?>

<div class="video-user-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'plan-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-2 control-label'],
                ],
    ]);
    ?>

    <?= $form->field($model, 'video_id')->dropDownList(Video::getVideoList(Yii::$app->user->id), ['prompt' => '请选择作品', 'disabled'=> !empty($model->video_id)])->label('作品') ?>

    <?php // $form->field($model, 'role')->dropDownList(MetaData::getGroupList('planRole'),['prompt'=>'请选择角色']) ?>

    <?= $form->field($model, 'role_name')->textInput(['maxlength' => true])->label('角色') ?>
    
    <?= $form->field($model, 'desc')->textarea(['maxlength' => true])->label('备注') ?>

    <?= Html::activeHiddenInput($model, 'uid') ?>


    <div class="form-group">
        <div class="col-sm-offset-2">
            <?= Html::submitButton('确定', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
