<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\extend\GamePrize */

$this->title = 'Update Game Prize: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Game Prizes', 'url' => ['index', 'game_id'=>$model->game_id]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="game-prize-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
