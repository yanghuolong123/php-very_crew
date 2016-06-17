<?php

use yii\helpers\Html;



$this->title = '编辑作品: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '我的作品', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="video-update">
    <p><?= Html::a('管理参与成员', ['video-user/index', 'id' => $model->id], ['class' => 'btn btn-success']) ?></p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
