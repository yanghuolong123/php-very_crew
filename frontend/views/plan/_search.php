<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\extend\MetaData;

?>

<div class="plan-search">

    <?php $form = ActiveForm::begin([
        'id' => 'plan-search-form',
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>
    
    <?= $form->field($model, 'title')->label('计划名称/ID') ?>
    
    <?= $form->field($model, 'tag',[
        'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n<div class=\"col-lg-2\">{error}</div>",
    ])->checkboxList(MetaData::getGroupList('videoTag')) ?>

    <?= $form->field($model, 'type')->dropDownList(MetaData::getGroupList('videoType'),['prompt'=>'请选择'])->label('视频类型') ?>
    
    <?= app\components\district\DistrictWidget::widget(['form'=>$form, 'model'=>$model, 'title'=>'拍摄地区']) ?>    
    
    <?= $form->field($model, 'plan_role', [
        'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n<div class=\"col-lg-2\">{error}</div>",
    ])->checkboxList(MetaData::getGroupList('planRole')) ?>

    <?= $form->field($model, 'plan_skill',[
        'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n<div class=\"col-lg-2\">{error}</div>",
    ])->checkboxList(MetaData::getGroupList('planSkill'))->label('所需特长及形象') ?>
        
    <?php // $form->field($model, 'content')->label('其他说明') ?>

    <div class="form-group">
        <div class="col-sm-1 col-md-offset-2 col-md-2">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
