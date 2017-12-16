<hr>
<h2>扫描微信公众号登陆Demo</h2>

<img src="<?= $qrImg ?>" />



<?php $this->beginBlock('qrcode-login-Js') ?>

var timer = setInterval(function(){
    $.get('/test/qrlogin?key=<?= $key ?>', function(e){
            if(e.success==false) {
                return false;
            }
            
            alert(e.data.nickname);
            clearInterval(timer);
        });
}, 1000);

<?php $this->endBlock() ?> 
<?php $this->registerJs($this->blocks['qrcode-login-Js'], \yii\web\View::POS_END); ?>

