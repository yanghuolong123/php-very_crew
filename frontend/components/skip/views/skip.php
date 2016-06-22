<?php

use yii\helpers\Html;
?>
<div class="jumbotron alert alert-warning">
    <?php echo Html::hiddenInput('seconds', $seconds, array('id' => 'seconds')); ?>
    <?php echo Html::hiddenInput('skipUrl', $skipUrl, array('id' => 'skipUrl')); ?>
        <?php echo Html::hiddenInput('closeWindow', $closeWindow, array('id' => 'closeWindow')); ?>
    <div class="msgInfo" style="">		
<?= $msg ?>
    </div>
    <p class="tipInfo" style="">请稍等......该页将在<span id='sec'>&nbsp;&nbsp;<?= $seconds; ?>&nbsp;&nbsp;</span>秒后自动跳转!<br><br/>
    <div class="goto">
        <p><a href="<?php echo Yii::$app->request->referrer; ?>" style="color:#3F3F3F;">返回上一页</a></p>
        <p><a href="<?php echo 'http://' . Yii::$app->request->serverName . Yii::$app->request->baseUrl . '/' . basename(Yii::$app->request->scriptFile); ?>" style="color:#3F3F3F;">返回首页</a></p>
    </div>
</div>

