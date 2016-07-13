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
    <p>    
    <?= Html::a('管理计划成员', ['plan-user/index', 'plan_id' => $model->id], ['class' => 'btn btn-info']) ?>
    </p>        

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
