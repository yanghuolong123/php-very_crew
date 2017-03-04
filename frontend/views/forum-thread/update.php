<?php

use yii\helpers\Html;

$this->title = '编辑帖子主题: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '论坛', 'url' => ['forum-forum/index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="forum-thread-update">

    <h1><?php //= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
