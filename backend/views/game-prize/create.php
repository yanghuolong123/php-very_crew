<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\extend\GamePrize */

$this->title = 'Create Game Prize';
$this->params['breadcrumbs'][] = ['label' => 'Game Prizes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-prize-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
