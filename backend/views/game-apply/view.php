<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\extend\GameApply */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Game Applies', 'url' => ['index', 'game_id'=>$model->game_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-apply-view">
<!--
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>-->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'game_id',
            'username',
            'amount',
            'summary',
            'join_num',
            'len_minute',
            'len_second',
            'condition',
            'ability',
            'advantage',
            'status',
            'create_time:datetime',
        ],
    ]) ?>

</div>
