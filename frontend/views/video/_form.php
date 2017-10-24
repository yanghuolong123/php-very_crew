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
    .state{
        color:#f71752;
    }
    span.text {
        color: #008200;
        font-family: fantasy;
    }
</style>

<div class="video-form">

    <?php $form = ActiveForm::begin([
        'id' => 'video-form',
        'options' => ['enctype' => 'multipart/form-data','class' => 'form-horizontal', 'onsubmit'=>''],
        'fieldClass' => 'app\components\ext\ExtActiveField',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?> 
    
    <?php if(isset($_GET['game_id']) && !empty($_GET['game_id'])): ?>
    <div class="form-group ">
        <label for="video-game" class="col-lg-2 control-label">所属大赛</label>
        <div class="col-lg-4"><?= Html::hiddenInput('game_id', $_GET['game_id']) ?><input type="text" maxlength="128" name="game" value="<?= app\models\extend\Games::findOne($_GET['game_id'])->name ?>" disabled="true" class="form-control" id="video-game"></div>
        <div class="col-lg-5"><div class="help-block"></div></div>
    </div>
    <?php else: ?>
    <div class="form-group ">
        <div class="col-lg-8 col-md-offset-1">
    <p class="text-warning center-block">此页为一般作品上传页面，如为参赛作品请在“参加比赛”-“上传参赛作品”页面进行作品提交</p>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if(!empty($planList)): ?>
    <?= $form->field($model, 'plan_id',[
        'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-5 plan_tips\">(*匹配计划后可直接导入此计划的成员信息，省去分别添加和重新填写)</div>",
    ])->dropDownList($planList,['prompt'=>'请选择'])->label('匹配计划') ?>
    <?php endif; ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>   
    
    <?= $form->field($model, 'type')->dropDownList(MetaData::getGroupList('videoType'),['prompt'=>'请选择']) ?>
    
    <?php echo app\components\district\DistrictWidget::widget(['form'=>$form, 'model'=>$model, 'title'=>'拍摄地区']) ?>
    
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
    ])->webuploaderInput() ?>
    
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
    
    $list = $('#thelist'),
    state = 'pending',
    uploader;
     
    uploader = WebUploader.create({
        // swf文件路径
        swf: '/plugin/webuploader/Uploader.swf',
        // 文件接收服务端。
        //server: '/goUpload/',
        server: '<?= Url::to(['upload/webupload']) ?>',
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#picker',
        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        resize: false,
        chunked: true,
        chunkSize:2*1024*1024,
        accept: {
	    title: 'Videos',
	    extensions: 'wmv,asf,asx,rm,rmvb,ram,avi,mpg,dat,mp4,mpeg,divx,m4v,mov,qt,flv,f4v,mp3,wav,aac,m4a,wma,ra,3gp,3g2,dv,vob,mkv,ts',
	    mimeTypes: 'video/*,audio/*'
	},
        fileNumLimit: 1,
        auto: true
    });
    
    // 当有文件被添加进队列的时候
    uploader.on( 'fileQueued', function( file ) {
    $list.append( '<div id="' + file.id + '" class="item">' +
      '<span class="info">' + file.name + ' </span>' +
      '<span class="state"> 等待上传...</span>' +
      '<span class="text">0%</span>' +
    '</div>' );
    });
    
    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
        var $li = $( '#'+file.id ),
          $percent = $li.find('.progress .progress-bar');
          

        // 避免重复创建
        if ( !$percent.length ) {
          $percent = $('<div class="progress progress-striped active">' +
           '<div class="progress-bar" role="progressbar" style="width: 0%">' +
           '</div>' +
          '</div>').appendTo( $li ).find('.progress-bar');
        }

        $li.find('span.state').text('上传中，请等候... ');
        
        $percent.css( 'width', percentage * 100 + '%' );
        if(percentage==1) {
            percentage = 0.99;
        }
        $li.find('span.text').text( Math.round( percentage * 100 ) + '%' );
    });
    
    uploader.on( 'uploadSuccess', function( file, obj ) {
        $( '#'+file.id ).find('span.state').text('上传成功 ');
        $( '#'+file.id ).find('span.text').text('100% ');
        $('#video-file').val(obj.data);
    });

    uploader.on( 'uploadError', function( file ) {
        $( '#'+file.id ).find('span.state').text('上传出错 ');
    });

    uploader.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').fadeOut();
    });
    
    
    $(document).on('change', '#video-plan_id', function(){
        $('#video-tag input').attr("checked",false);
        $('#video-type').val("");
        var plan_id = $(this).val();
        $.post('<?= Url::to(['plan/ajax-get-sel']) ?>', {plan_id:plan_id}, function(o) {
            if(!o.success) {
                return;
            }
            var data = o.data;
            $('#video-type').val(data.type);
            $('#video-province').val(data.province).trigger('change');
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
            setTimeout(function(){
                $('#video-city').val(data.city).trigger('change');
                setTimeout(function(){
                    $('#video-county').val(data.county);
                }, 1000);
            },1000);
            
        });
    });
});

<?php $this->endBlock() ?>  
<?php $this->registerJsFile('/plugin/webuploader/webuploader.nolog.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJs($this->blocks['uploadVideoJs'], \yii\web\View::POS_END); ?>
<?php $this->registerCssFile('/plugin/webuploader/webuploader.css',['depends'=>['app\assets\AppAsset']]); ?>
