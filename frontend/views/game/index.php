<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\extend\MetaData;

$this->registerJsFile('@web/js/main.js',['depends'=>['app\assets\AppAsset']]);  

$planList = \app\models\extend\Plan::getPlanList(Yii::$app->user->id);
?>

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

    
    <?= $form->field($model, 'file')->fileInput() ?>   
    <?= $form->field($model, 'file')->imgInput() ?>

    <div class="form-group">
        <div class="col-sm-1 col-md-offset-2">
        <?= Html::submitButton('提交并保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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
