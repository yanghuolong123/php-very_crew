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
    
    <?= app\components\district\DistrictWidget::widget(['form'=>$form, 'model'=>$model, 'title'=>'出生地区', 'level'=>4]) ?>   
    
    <?= $form->field($model, 'birthday')->widget(
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
    ]);?>

    <?= $form->field($model, 'weixin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'qq')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'height')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>

    

    <?= $form->field($model, 'good_at_job', [
        'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n<div class=\"col-lg-2\">{error}</div>",
    ])->checkboxList(MetaData::getGroupList('planRole')) ?>

    <?= $form->field($model, 'speciality', [
        'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n<div class=\"col-lg-2\">{error}</div>",
    ])->checkboxList(MetaData::getGroupList('planSkill')) ?>

    <?= $form->field($model, 'usingtime', [
        'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n<div class=\"col-lg-2\">{error}</div>",
    ])->radioList(MetaData::getGroupList('usingTime')) ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2">
        <?= Html::submitButton('提交并保存', ['class' => 'btn btn-success btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
