<?php

use yii\helpers\Html;

$this->title = '发帖';
$this->params['breadcrumbs'][] = ['label' => '论坛', 'url' => ['forum-forum/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forum-thread-create">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
