<?php

use yii\helpers\Html;



$this->title = '编辑个人资料: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '个人资料', 'url' => ['view', 'uid' => $model->uid]];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="user-profile-update">

    <?= $this->render('_form', [
        'model' => $model,
        'userModel' => $userModel
    ]) ?>

</div>
