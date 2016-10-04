<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\extend\GameVideo */

$this->title = 'Update Game Video: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Game Videos', 'url' => ['index', 'game_id'=>$model->game_id]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="game-video-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
