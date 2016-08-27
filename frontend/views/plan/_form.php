<?php

//use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\extend\MetaData; 
use dosamigos\datepicker\DatePicker;

?>

<style>
    .begin_time_label{
        padding-right: 25px;
    }
</style>

<div class="plan-form">

    <?php $form = ActiveForm::begin([
        'id' => 'plan-form',
        //'enableClientValidation'=> false,
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('计划名称') ?>
    
    <?= $form->field($model, 'type')->dropDownList(MetaData::getGroupList('videoType'),['prompt'=>'请选择'])->label('视频类型') ?>
    
    <?= $form->field($model, 'tag')->checkboxList(MetaData::getGroupList('videoTag')) ?>
    
    <?=
    $form->field($model, 'begin_time',[
        'template' => "{label}\n<div class=\"col-lg-3\" style=\"padding-left: 5px;margin-bottom: 5px;\">{input}</div>\n",
        'options' => ['class' => 'form-horizontal'],
        'labelOptions' => ['class' => 'col-lg-2 control-label begin_time_label'],
    ])->widget(
            DatePicker::className(), [
        // inline too, not bad
        'inline' => false,
        'language' => 'zh-CN',
        // modify template for custom rendering
        'template' => '{addon}{input}',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>
    
    <?=
    $form->field($model, 'end_time',[
        'template' => "{label}\n<div class=\"col-lg-3\" style=\"padding-left: 5px;margin-bottom: 5px;\">{input}</div><div class=\"col-lg-2\">{error}</div>\n",
        //'options' => ['class' => 'form-horizontal'],
        'labelOptions' => ['class' => 'col-lg-1 control-label'],
    ])->widget(
            DatePicker::className(), [
        // inline too, not bad
        'inline' => false,
        'language' => 'zh-CN',
        // modify template for custom rendering
        'template' => '{addon}{input}',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>

    <?= app\components\district\DistrictWidget::widget(['form'=>$form, 'model'=>$model, 'title'=>'拍摄地区']) ?>
    
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>    

    <?= $form->field($model, 'plan_role')->checkboxList(MetaData::getGroupList('planRole')) ?>

    <?= $form->field($model, 'plan_skill')->checkboxList(MetaData::getGroupList('planSkill'))->label('所需特长及形象') ?>   
    
    <?= $form->field($model, 'remark')->textarea()->label('其他说明') ?>
   
    <div class="form-group">
        <div class="col-sm-1 col-md-offset-2">
        <?= Html::submitButton('提交并保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
