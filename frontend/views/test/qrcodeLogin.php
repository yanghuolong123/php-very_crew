<hr>
<h2>扫描微信公众号登陆Demo</h2>

<img src="<?= $qrImg ?>" />



<?php $this->beginBlock('qrcode-login-Js') ?>
$(function(){
        alert(1111);
});
<?php $this->endBlock() ?> 
<?php $this->registerJs($this->blocks['qrcode-login-Js'], \yii\web\View::POS_END); ?>

