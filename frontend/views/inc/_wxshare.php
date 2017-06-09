<?php

$this->registerJsFile('http://res.wx.qq.com/open/js/jweixin-1.0.0.js', ['depends' => ['app\assets\AppAsset']]);

$jssdk = new \app\modules\weixin\models\JSSDK();
$signPackage = $jssdk->GetSignPackage();
?>

<?php $this->beginBlock('wx-share-Js') ?> 

wx.config({
    debug: false,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage']
});

wx.ready(function(){	
	
        // 分享到朋友圈
        wx.onMenuShareTimeline({
            title: '<?= $title ?>', // 分享标题
            link: '<?= $shareUrl ?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: '<?= Yii::$app->request->hostInfo.$logo ?>', // 分享图标
            success: function () { 
                // 用户确认分享后执行的回调函数
            },
            cancel: function () { 
                // 用户取消分享后执行的回调函数
            }
        });

        // 分享给朋友
        wx.onMenuShareAppMessage({
          title: '<?= $title ?>', // 分享标题
          desc: '<?= $content ?>', // 分享描述
          link: '<?= $shareUrl ?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
          imgUrl: '<?= Yii::$app->request->hostInfo.$logo ?>', // 分享图标
          //type: '', // 分享类型,music、video或link，不填默认为link
          //dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
          success: function () { 
              // 用户确认分享后执行的回调函数
          },
          cancel: function () { 
              // 用户取消分享后执行的回调函数
          }

      });   
});  
<?php $this->endBlock() ?> 
<?php $this->registerJs($this->blocks['wx-share-Js'], \yii\web\View::POS_END); ?>