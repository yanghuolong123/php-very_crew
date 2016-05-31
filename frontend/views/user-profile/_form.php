<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use app\models\extend\Distrinct;
use app\models\extend\MetaData;

$this->registerJsFile('@web/js/main.js',['depends'=>['app\assets\AppAsset']]); 

?>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin([
        'id'=>'userprofile-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldClass' => 'app\util\ExtActiveField',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>  
    
    <?= $form->field($userModel, 'username')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($userModel, 'avatar')->imgInput() ?>
    
    <?= $form->field($userModel, 'email')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($userModel, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->radioList(MetaData::getGroupList('gender')) ?>
    
    <?= $form->field($model, 'province')->dropDownList(Distrinct::getDistrictList(0), [
        'prompt'=>'请选择省',
        'onchange' => '
            $.post("index.php?r=district/index&pid="+$(this).val(), function(data){
                $("#userprofile-city").html("<option value=\"\">请选择城市</option>").append(data);
                $("#userprofile-county").html("<option value=\"\">请选择县</option>");
                $("#userprofile-country").html("<option value=\"\">请选择县</option>");
            });   
        ',
    ]) ?>

    <?= $form->field($model, 'city')->dropDownList(Distrinct::getDistrictList($model->province), [
        'prompt'=>'请选择城市',
        'onchange' => '
            $.post("index.php?r=district/index&pid="+$(this).val(), function(data){               
                $("#userprofile-county").html("<option value=\"\">请选择县</option>").append(data);  
                $("#userprofile-country").html("<option value=\"\">请选择县</option>");
            });   
        ',
    ]) ?>

    <?= $form->field($model, 'county')->dropDownList(Distrinct::getDistrictList($model->city), [
        'prompt'=>'请选择县', 
        'onchange' => '
            $.post("index.php?r=district/index&pid="+$(this).val(), function(data){               
                $("#userprofile-country").html("<option value=\"\">请选择县</option>").append(data);               
            });   
        ',
    ]) ?>

    <?= $form->field($model, 'country')->dropDownList(Distrinct::getDistrictList($model->city), [
        'prompt'=>'请选择县',        
    ]) ?>    
    
    <?= $form->field($model, 'birthday')->widget(
            DatePicker::className(), [
                    // inline too, not bad
                    'inline' => true, 
                    'language' => 'zh-CN',
                    // modify template for custom rendering
                    'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                    'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                    ]
    ]);?>

    <?= $form->field($model, 'weixin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'qq')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'height')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>

    

    <?= $form->field($model, 'good_at_job')->checkboxList(MetaData::getGroupList('planRole')) ?>

    <?= $form->field($model, 'speciality')->checkboxList(MetaData::getGroupList('planSkill')) ?>

    <?= $form->field($model, 'usingtime')->radioList(MetaData::getGroupList('usingTime')) ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2">
        <?= Html::submitButton('提交并保存', ['class' => 'btn btn-success btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
