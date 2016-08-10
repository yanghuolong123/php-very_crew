<?php

use yii\helpers\Html;

$this->title = '发布计划';
$this->params['breadcrumbs'][] = ['label' => '搜计划', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
