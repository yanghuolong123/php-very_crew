<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\extend\Plan */

$this->title = '编辑我的计划: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '我的计划', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="plan-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
