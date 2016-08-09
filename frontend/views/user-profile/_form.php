<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use app\models\extend\MetaData;

$this->registerJsFile('@web/js/upload.js', ['depends' => ['app\assets\AppAsset']]);
?>

<style>
    .thumbnail {
        min-height:220px;
    }
    .thumbnail img {
        height: 220px;
        width: 220px;
    }
    .plan_tips {
        color: #aaa;
    }
    .imgbox {
        width: 260px;
    }
</style>

<div class="user-profile-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'userprofile-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldClass' => 'app\util\ExtActiveField',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-2 control-label'],
                ],
    ]);
    ?>  

    <?= $form->field($userModel, 'username')->textInput(['maxlength' => true]) ?>
<!--
    <?php if (!empty($userModel->thumb_avatar)): ?>
        <div class="form-group field-user-thumb_avatar">
            <label for="user-thumb_avatar" class="col-lg-2 control-label">缩略图</label>
            <div class="col-lg-3"><img class="thumbnail" src="<?= $userModel->thumb_avatar ?>"></div>
            <div class="col-lg-1"><button class="btn btn-info update_avatarImg" type="button">修改</button></div>
            <div class="col-lg-2"><div class="help-block"></div></div>
        </div>
        <?php // $form->field($userModel, 'thumb_avatar')->imgInput() ?>
    <?php endif; ?>
-->
    <?php // app\components\crop\CropWidget::widget(['form' => $form, 'model' => $userModel, 'title' => '头像', 'attribute' => 'avatar']) ?>
    <?php echo  $form->field($userModel, 'avatar', [
        'template' => "{label}\n<div class=\"col-lg-3 imgbox\">{input}</div>\n<div class=\"col-lg-5 plan_tips \">*请上传宽高比近似为1比1的头像以获得最佳显示效果。<p>{error}</p></div>",
    ])->uploadImg() ?>
    
    <?= $form->field($model, 'gender')->radioList(MetaData::getGroupList('gender')) ?>   

    <?=
    $form->field($model, 'birthday')->widget(
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

    <?= app\components\district\DistrictWidget::widget(['form' => $form, 'model' => $model, 'title' => '所在地区', 'level' => 3]) ?>   

    <?= $form->field($model, 'height')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?> 

    <?=
    $form->field($model, 'good_at_job', [
        'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n<div class=\"col-lg-2\">{error}</div>",
    ])->checkboxList(MetaData::getGroupList('planRole'))->label('擅长')
    ?>

    <?=
    $form->field($model, 'speciality', [
        'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n<div class=\"col-lg-2\">{error}</div>",
    ])->checkboxList(MetaData::getGroupList('planSkill'))->label('表演特长及形象')
    ?>

    <?php
//    $form->field($model, 'usingtime', [
//        'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n<div class=\"col-lg-2\">{error}</div>",
//    ])->radioList(MetaData::getGroupList('usingTime')) 
    ?>

    <div class="form-group">
    <div class="col-md-offset-2 col-lg-4 text-warning">联系方式(*建议填写您最常用的联系方式，以便有合作意向的拍摄者能够及时联系到您。)</div>    
    </div>

    <?= $form->field($model, 'weixin')->textInput(['maxlength' => true]) ?>    

    <?= $form->field($userModel, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'qq')->textInput(['maxlength' => true]) ?>

    <?= $form->field($userModel, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remark')->textarea(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-sm-1 col-md-offset-2 col-md-2">
        <?= Html::submitButton('提交并保存', ['class' => 'btn btn-success btn-primary']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>

</div>

<?php $this->beginBlock('updateAvatarImgJs') ?>
$(function(){
<?php if (!empty($userModel->thumb_avatar)): ?>
    $('.form-crop').hide();
<?php endif; ?>
$('.update_avatarImg').click(function(){
$('.form-crop').show();
});
});
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['updateAvatarImgJs'], \yii\web\View::POS_END); ?>