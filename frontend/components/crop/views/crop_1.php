<?php 
use yii\helpers\Url;
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
</style>
<?php $this->beginBlock('cropImgJs') ?>


  $(function(){

    $('.cropbox').Jcrop({
      aspectRatio: 1,
      onSelect: updateCoords
    });
    
    $('#cut_img').click(function(){
        var cropImg = $('.crop_img').val();
        if(cropImg == '') {
            alerting({msg: '请先上传图像'});
        }
        
        var x = $('#x').val();
        var y = $('#y').val();
        var w = $('#w').val();
        var h = $('#h').val();
        if(x=='' || y=='' || w=='' || h=='') {
            alerting({msg: '请先选中要裁剪的图像'});
        }        
        
        $.post('<?= Url::to(['upload/cut-img']) ?>', {x:x,y:y,w:w,h:h,cropImg:cropImg}, function(obj){
            if(!obj.success) {
                return;
            }
            alerting({msg: '裁剪图像成功'});
        });
    });

  });

  function updateCoords(c)
  {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
    
  };

  function checkCoords()
  {
    if (parseInt($('#w').val())) return true;
    alert('Please select a crop region then press submit.');
    return false;
  };
  
  $('.upload_img').on('click', function(evt) {
    var uploader = new PicUploader({
        success: function(obj) {
            $('img.cropbox').attr('src', obj['data']);
            $('a.crop_thumbnail').next('input').val(obj['data']);
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
    'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-2\"><a href=\"#\" class=\"crop_thumbnail\"><img src=\"\" alt=\"\"></a></div><div class=\"col-lg-2\">{error}</div>",
])->cropImgInput(['class'=>'crop_img']) ?>
