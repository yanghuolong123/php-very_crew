<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\extend\GameVideo */

$this->title = 'Create Game Video';
$this->params['breadcrumbs'][] = ['label' => 'Game Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-video-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
