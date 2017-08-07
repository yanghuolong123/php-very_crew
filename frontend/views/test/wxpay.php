<?php
use yii\helpers\Url;
?>
<br/><br/><br/>
<div style="margin-left: 10px;color:#556B2F;font-size:30px;font-weight: bolder;">扫描支付模式二</div><br/>
<img alt="模式二扫码支付" src="<?= Url::to(['/weixin/pay/qrcode', 'data'=>urlencode($url)]) ?>" style="width:150px;height:150px;"/>