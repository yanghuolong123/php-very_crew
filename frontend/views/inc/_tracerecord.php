<?php 
use yii\helpers\Url;
?>
<?php $this->beginBlock('trace-record-Js') ?> 
$(function(){
    var cUrl = '<?= Yii::$app->request->url ?>'; // window.location.href;
    $.post("<?= Url::to(['home/trace-record']) ?>", {accessUrl:cUrl}, function(e){
         
    });
});
<?php $this->endBlock() ?> 
<?php $this->registerJs($this->blocks['trace-record-Js'], \yii\web\View::POS_END); ?> 