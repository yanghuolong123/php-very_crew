<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\extend\ForumForum */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Forum Forums', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forum-forum-view">

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
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'sort',
            'status',
            'createtime:datetime',
            'updatetime:datetime',
        ],
    ]) ?>

</div>
