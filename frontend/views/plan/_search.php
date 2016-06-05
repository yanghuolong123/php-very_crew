<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\extend\MetaData;
use app\models\extend\Distrinct;

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
    
    <?= $form->field($model, 'title')->label('计划名称') ?>

    <?= $form->field($model, 'type')->dropDownList(MetaData::getGroupList('videoType'),['prompt'=>'请选择']) ?>
    
    <?= $form->field($model, 'province')->dropDownList(Distrinct::getDistrictList(0), [
        'prompt'=>'请选择省',
        'onchange' => '
            $.post("index.php?r=district/index&pid="+$(this).val(), function(data){
                $("#plansearch-city").html("<option value=\"\">请选择城市</option>").append(data);
                $("#plansearch-county").html("<option value=\"\">请选择县</option>");
            });   
        ',
    ]) ?>
    
    <?= $form->field($model, 'city')->dropDownList(Distrinct::getDistrictList($model->province), [
        'prompt'=>'请选择城市',
        'onchange' => '
            $.post("index.php?r=district/index&pid="+$(this).val(), function(data){               
                $("#plansearch-county").html("<option value=\"\">请选择县</option>").append(data);               
            });   
        ',
    ]) ?>
    
    <?= $form->field($model, 'county')->dropDownList(Distrinct::getDistrictList($model->city), [
        'prompt'=>'请选择县',        
    ]) ?>
    
    <?= $form->field($model, 'plan_role', [
        'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n<div class=\"col-lg-2\">{error}</div>",
    ])->checkboxList(MetaData::getGroupList('planRole')) ?>

    <?= $form->field($model, 'plan_skill',[
        'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n<div class=\"col-lg-2\">{error}</div>",
    ])->checkboxList(MetaData::getGroupList('planSkill')) ?>
        
    <?= $form->field($model, 'content') ?>

    <div class="form-group">
        <div class="col-sm-offset-2">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
