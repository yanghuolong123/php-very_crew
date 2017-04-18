<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\extend\GameApply */

$this->title = 'Update Game Apply: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Game Applies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="game-apply-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
