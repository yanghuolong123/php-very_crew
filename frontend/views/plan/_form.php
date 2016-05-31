<?php

//use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\extend\MetaData;
use app\models\extend\Distrinct;
use app\models\extend\Video;


?>

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

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'type')->dropDownList(MetaData::getGroupList('videoType'),['prompt'=>'请选择']) ?>
    
    <?= $form->field($model, 'tag')->checkboxList(MetaData::getGroupList('videoTag')) ?>

    <?= $form->field($model, 'province')->dropDownList(Distrinct::getDistrictList(0), [
        'prompt'=>'请选择省',
        'onchange' => '
            $.post("index.php?r=district/index&pid="+$(this).val(), function(data){
                $("#plan-city").html("<option value=\"\">请选择城市</option>").append(data);
                $("#plan-county").html("<option value=\"\">请选择县</option>");
            });   
        ',
    ]) ?>
    
    <?= $form->field($model, 'city')->dropDownList(Distrinct::getDistrictList($model->province), [
        'prompt'=>'请选择城市',
        'onchange' => '
            $.post("index.php?r=district/index&pid="+$(this).val(), function(data){               
                $("#plan-county").html("<option value=\"\">请选择县</option>").append(data);               
            });   
        ',
    ]) ?>
    
    <?= $form->field($model, 'county')->dropDownList(Distrinct::getDistrictList($model->city), [
        'prompt'=>'请选择县',        
    ]) ?>
    
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>    

    <?= $form->field($model, 'plan_role')->checkboxList(MetaData::getGroupList('planRole')) ?>

    <?= $form->field($model, 'plan_skill')->checkboxList(MetaData::getGroupList('planSkill')) ?>
    
    <?php if(Video::getVideoList(Yii::$app->user->id)): ?>
    <?= $form->field($model, 'video_ids')->checkboxList(Video::getVideoList(Yii::$app->user->id),['separator'=>'<br>']) ?>
    <?php endif; ?>
    
    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>
   
    <div class="form-group">
        <div class="col-sm-offset-2">
        <?= Html::submitButton('提交并保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
