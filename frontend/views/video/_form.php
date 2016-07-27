<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\extend\MetaData;

$this->registerJsFile('@web/js/upload.js',['depends'=>['app\assets\AppAsset']]);  

$planList = \app\models\extend\Plan::getPlanList(Yii::$app->user->id);
?>
<style>
    .plan_tips {
        color: #aaa;
    }
    .thumbnail img {
        height: 220px;
        width: 350px;
    }
</style>

<div class="video-form">

    <?php $form = ActiveForm::begin([
        'id' => 'video-form',
        'options' => ['enctype' => 'multipart/form-data','class' => 'form-horizontal', 'onsubmit'=>''],
        'fieldClass' => 'app\util\ExtActiveField',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?> 
    
    <?php if(!empty($planList)): ?>
    <?= $form->field($model, 'plan_id',[
        'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-5 plan_tips\">(*匹配计划后可直接导入此计划的成员信息，省去分别添加和重新填写)</div>",
    ])->dropDownList($planList,['prompt'=>'请选择'])->label('匹配计划') ?>
    <?php endif; ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>   
    
    <?= $form->field($model, 'type')->dropDownList(MetaData::getGroupList('videoType'),['prompt'=>'请选择']) ?>
    
    <?= $form->field($model, 'tag')->checkboxList(MetaData::getGroupList('videoTag')) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?php echo  $form->field($model, 'logo')->uploadImg() ?>
    <?php //app\components\crop\CropWidget::widget(['form'=>$form, 'model'=>$model, 'title'=>'作品封面', 'attribute'=>'logo','options'=>['style'=>'height:220px;'], 'defaultVal'=>'./image/blank_img.jpg']) ?>

    <p></p><p></p><br>
    <?= $form->field($model, 'file')->uploadifyInput() ?>    

    <div class="form-group">
        <div class="col-sm-1 col-md-offset-2">
        <?= Html::submitButton( $model->isNewRecord ? '保存，下一步' : '提交并保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->beginBlock('uploadVideoJs') ?> 

$(function() {
    $("#file_upload").uploadify({
        //debug    : true,
        multi    : false,
        uploadLimit : 1,
        queueSizeLimit : 1,
        buttonText  : '上传视频',
        removeCompleted : false,
        fileObjName   : 'file',
        fileSizeLimit : 0,
        height        : 30,
        swf           : '/plugin/uploadify/uploadify.swf',
        uploader      : 'index.php?r=upload/upload-file',
        width         : 120,
        onUploadSuccess : function(file, data, response) {
            var res = eval("("+data+")");
            $('#video-file').val(res['data']);
        }

    });
});

<?php $this->endBlock() ?>  
<?php $this->registerJsFile('/plugin/uploadify/jquery.uploadify.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJs($this->blocks['uploadVideoJs'], \yii\web\View::POS_END); ?>
<?php $this->registerCssFile('/plugin/uploadify/uploadify.css',['depends'=>['app\assets\AppAsset']]); ?>
