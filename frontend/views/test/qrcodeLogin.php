<hr>
<h2>扫描微信公众号登陆Demo</h2>

<div id="login_info">
    <h3 id="nickname"></h3>
<img id="login_img" src="<?= $qrImg ?>" />
</div>



<?php $this->beginBlock('qrcode-login-Js') ?>

var timer = setInterval(function(){
    $.get('/test/qrlogin?key=<?= $key ?>', function(e){
            if(e.success==false) {
                return false;
            }
            
            clearInterval(timer);
            
            $("#nickname").html(e.data.nickname+", 欢迎你登陆成功！");
            $("#login_img").attr("src",e.data.headimgurl);
            //alert(e.data.nickname);
            
        });
}, 1000);

<?php $this->endBlock() ?> 
<?php $this->registerJs($this->blocks['qrcode-login-Js'], \yii\web\View::POS_END); ?>

