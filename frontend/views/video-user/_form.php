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

    <?= $form->field($model, 'video_id')->dropDownList(Video::getVideoList(Yii::$app->user->id), ['prompt' => '请选择作品'])->label('作品') ?>

    <?= $form->field($model, 'role')->dropDownList(MetaData::getGroupList('planRole'),['prompt'=>'请选择角色']) ?>

    <?= $form->field($model, 'is_star')->radioList([0 => '否', 1 => '是']) ?>
    
    <?php if(!$model->isNewRecord): ?>
    <?= $form->field($model, 'status')->dropDownList([1=>'已确定', 0=> '待确定']) ?>
    <?php endif; ?>

    <?= $form->field($model, 'desc')->textarea(['maxlength' => true]) ?>

    <?= Html::activeHiddenInput($model, 'uid') ?>


    <div class="form-group">
        <div class="col-sm-offset-2">
            <?= Html::submitButton('确定', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
