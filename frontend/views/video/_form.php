<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\extend\MetaData;
use yii\helpers\Url;

$this->registerJsFile('@web/js/upload.js',['depends'=>['app\assets\AppAsset']]);  

$planList = \app\models\extend\Plan::getPlanList(Yii::$app->user->id);
?>
<style>
    .plan_tips {
        color: #aaa;
    }
    .thumbnail {
        min-height:220px;
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
    ])->dropDownList($planList,['prompt'=>'请选择','onchange'=>'selVideo(this)'])->label('匹配计划') ?>
    <?php endif; ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>   
    
    <?= $form->field($model, 'type')->dropDownList(MetaData::getGroupList('videoType'),['prompt'=>'请选择']) ?>
    
    <?php // app\components\district\DistrictWidget::widget(['form'=>$form, 'model'=>$model, 'title'=>'拍摄地区']) ?>
    
    <?= $form->field($model, 'tag', [
        'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
    ])->checkboxList(MetaData::getGroupList('videoTag')) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?php echo  $form->field($model, 'logo',[
        'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-5 plan_tips\">请上传宽高比近似为1.6比1的封面以获得最佳显示效果。参考像素比（480，300）（560，350）（640，400）（720，450）（800，500）（880，550）（960，600）<p>{error}</p></div>",
    ])->uploadImg(['width'=>350, 'height'=>220]) ?>
    <?php //app\components\crop\CropWidget::widget(['form'=>$form, 'model'=>$model, 'title'=>'作品封面', 'attribute'=>'logo','options'=>['style'=>'height:220px;'], 'defaultVal'=>'./image/blank_img.jpg']) ?>

    <p></p><p></p><br>
    <?= $form->field($model, 'file',[
        'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-5 plan_tips\">非常剧组不会对您的视频进行压缩，所以上传前请务必转码，通过降低比特率（码率）等参数来降低原始视频的大小，以保证在线播放的流畅。<br>推荐转码软件：QQ影音、狸窝。<br>推荐比特率:1000-1500kbps。<br>推荐上传格式：MP4。<p>{error}</p></div>",
    ])->uploadifyInput() ?> 
    
    <?= $form->field($model, 'remark')->textarea() ?>

    <p></p><p></p><br>
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

function selVideo(obj) {
    $('#video-tag input').attr("checked",false);
    $('#video-type').val("");
    var plan_id = $(obj).val();
    $.post('<?= Url::to(['plan/ajax-get-sel']) ?>', {plan_id:plan_id}, function(o) {
        if(!o.success) {
            return;
        }
        var data = o.data;
        $('#video-type').val(data.type);
        var vArr = data.tag.split(',');                 
        $('#video-tag input').each(function(index, e){
            //$(e).attr("checked",false);
            var v = $(e).val();            
            $.each(vArr, function(i, n){
                if(n == v) {
                    e.checked=true;
                    //$(e).attr("checked",true);
                    return true;
                }
            });
        });
    });
}

<?php $this->endBlock() ?>  
<?php $this->registerJsFile('/plugin/uploadify/jquery.uploadify.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJs($this->blocks['uploadVideoJs'], \yii\web\View::POS_END); ?>
<?php $this->registerCssFile('/plugin/uploadify/uploadify.css',['depends'=>['app\assets\AppAsset']]); ?>
