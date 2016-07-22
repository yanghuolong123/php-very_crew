<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\extend\MetaData;
?>

<div class="user-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-2 control-label'],
                ],
    ]);
    ?>

    <?= $form->field($model, 'nickname')->label('姓名/ID') ?>

    <?= $form->field($model, 'gender')->radioList(MetaData::getGroupList('gender'))->label("性别") ?>
    
    <?= app\components\district\DistrictWidget::widget(['form'=>$form, 'model'=>$model, 'title'=>'所在地区']) ?>

    <?=
    $form->field($model, 'good_at_job', [
        'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n<div class=\"col-lg-2\">{error}</div>",
    ])->checkboxList(MetaData::getGroupList('planRole'))->label('擅长')
    ?>

    <?=
    $form->field($model, 'speciality', [
        'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n<div class=\"col-lg-2\">{error}</div>",
    ])->checkboxList(MetaData::getGroupList('planSkill'))->label('所需特长及形象')
    ?>

    <?php
//    $form->field($model, 'usingtime', [
//        'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n<div class=\"col-lg-2\">{error}</div>",
//    ])->radioList(MetaData::getGroupList('usingTime'))->label('可用于拍摄时间')
    ?>

    <div class="form-group">
        <div class="col-sm-1 col-md-offset-2 col-md-2">
    <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>

</div>
