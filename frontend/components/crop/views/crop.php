<?php 
use yii\helpers\Url;
use yii\helpers\Html;
?>
<style>
.crop_thumbnail {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    display: block;
    line-height: 1.42857;
    margin-top: 10px;
    margin-bottom: 10px;
    padding: 4px;
    transition: border 0.2s ease-in-out 0s;
}
.crop_thumbnail > img, .crop_thumbnail a > img {
    margin-left: auto;
    margin-right: auto;
    display: block;
    height: auto;
    max-width: 100%;
}

#preview-pane {
  display: block;
  position: absolute;
  z-index: 1000;
  top: 10px;
  right: -280px;
  padding: 6px;
  border: 1px rgba(0,0,0,.4) solid;
  background-color: white;

  -webkit-border-radius: 6px;
  -moz-border-radius: 6px;
  border-radius: 6px;

  -webkit-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
  -moz-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
  box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
}


#preview-pane .preview-container {
    height: 170px;
    overflow: hidden;
    width: 250px;
}
</style>
<?php $this->beginBlock('cropImgJs') ?>


  $(function(){
    var jcrop_api,
        boundx,
        boundy,
        $preview = $('#preview-pane'),
        $pcnt = $('#preview-pane .preview-container'),
        $pimg = $('#preview-pane .preview-container img'),
        xsize = $pcnt.width(),
        ysize = $pcnt.height();

    $('.cropbox').Jcrop({
      onChange: updatePreview,
      onSelect: updatePreview,
      aspectRatio: xsize / ysize
    },function(){
      var bounds = this.getBounds();
      boundx = bounds[0];
      boundy = bounds[1];      
      jcrop_api = this;
      $preview.appendTo(jcrop_api.ui.holder);
    });
    
    function updatePreview(c)
    {
      if (parseInt(c.w) > 0)
      {
          var rx = xsize / c.w;
          var ry = ysize / c.h;

          $pimg.css({
            width: Math.round(rx * boundx) + 'px',
            height: Math.round(ry * boundy) + 'px',
            marginLeft: '-' + Math.round(rx * c.x) + 'px',
            marginTop: '-' + Math.round(ry * c.y) + 'px'
          });
      }

      $('#x').val(c.x);
      $('#y').val(c.y);
      $('#w').val(c.w);
      $('#h').val(c.h);

    };
    
    $('#cut_img').click(function(){
        var cropImg = $('.crop_img').val();
        if(cropImg == '') {
            alerting({msg: '请先上传图像'});
            return;
        }
        
        var x = $('#x').val();
        var y = $('#y').val();
        var w = $('#w').val();
        var h = $('#h').val();
        if(x=='' || y=='' || w=='' || h=='') {
            alerting({msg: '请先选中要裁剪的图像'});
            return;
        }        
        
        $.post('<?= Url::to(['upload/cut-img']) ?>', {x:x,y:y,w:w,h:h,cropImg:cropImg}, function(obj){
            if(!obj.success) {
                return;
            }
            $('.thumb_img').val(obj.data);
            greeting({msg: '裁剪图像成功'});
        });
    });

  });  
  
  $('.upload_img').on('click', function(evt) {
    var uploader = new PicUploader({
        success: function(obj) {
            $('img.cropbox').attr('src', obj['data']);
            $('.crop_img').val(obj['data']);
            $('.jcrop-holder img').attr('src', obj['data']);
        }
    });
    
    uploader.start();    
  });
  
  $('a.crop_thumbnail').on('click', function(evt) {
    evt.preventDefault();
  });
  


<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cropImgJs'], \yii\web\View::POS_END); ?>
  
<?= $form->field($model, $attribute,[
    'options' => $options,
    'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div id=\"preview-pane\"><div class=\"preview-container\"><img src=\"".$model->$attribute."\" class=\"jcrop-preview\" alt=\"Preview\" /></div></div><div class=\"col-lg-2\">{error}</div>",
])->cropImgInput() ?>

<?php if($model->{$attribute} == $defaultVal) {
    $model->{$attribute} = '';
} ?>

<?= Html::activeHiddenInput($model, $attribute,['class'=>'crop_img']) ?>
<?= Html::activeHiddenInput($model, 'thumb_'.$attribute,['class'=>'thumb_img']) ?>

<div class="clearfix"></div>