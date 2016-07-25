<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\extend\MetaData;

?>

<div class="video-search">

    <?php $form = ActiveForm::begin([
        'id' => 'video-search-form',
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>


    <?= $form->field($model, 'title')->label('视频名称/ID') ?>
    
    <?= app\components\district\DistrictWidget::widget(['form'=>$form, 'model'=>$model, 'title'=>'拍摄地区']) ?>
    
    <?= $form->field($model, 'type')->dropDownList(MetaData::getGroupList('videoType'),['prompt'=>'请选择']) ?>
    
    <?= $form->field($model, 'tag')->checkboxList(MetaData::getGroupList('videoTag')) ?>

    <?php // $form->field($model, 'content') ?>

    <div class="form-group">
        <div class="col-sm-1 col-md-offset-2 col-md-2">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
