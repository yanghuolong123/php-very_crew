<?php

//use Yii;
use yii\helpers\Url; 

$this->title = '消息提醒';
$this->params['breadcrumbs'][] = $this->title;
 
?>

<div class="alert alert-success">
    <h4>注册成功！</h4>
    <p>为了大家更好地了解你，并获得更多合作机会，建议您尽快在 <a href="<?= Url::to(['user-profile/update', 'uid'=>Yii::$app->user->id]) ?>">“完善我的资料”</a> 页面完善个人信息</p>
    <p><a class="btn btn-primary" href="<?= Url::to(['user-profile/update', 'uid'=>Yii::$app->user->id]) ?>">现在就去 &raquo;</a></p>    
</div>