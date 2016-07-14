<?php

use yii\helpers\Html;

$this->title = '编辑计划成员';
$this->params['breadcrumbs'][] = ['label' => '计划成员管理', 'url' => ['index', 'plan_id'=>$model->plan_id]];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="plan-user-update">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
