<?php

use yii\helpers\Url;
use app\models\extend\Plan;
use app\models\extend\User;

$this->title = '消息提醒';
$this->params['breadcrumbs'][] = $this->title;

$plan = Plan::findOne($data);
$user = User::getInfo($plan->uid);
?>

<div class="alert alert-success">
    <h4>您已加入计划:<?= $plan->title?> 的备选人员名单。计划发起人：<?= $user->nickname ?>。建议您主动联系他沟通合作事宜。</h4>
    <p><a class="btn btn-primary" href="<?= Url::to(['view', 'id'=>$plan->id]) ?>" role="button">确定</a></p>
</div>