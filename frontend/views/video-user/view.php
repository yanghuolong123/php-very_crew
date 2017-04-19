<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\extend\VideoUser */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Video Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-user-view">

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
            'uid',
            'video_id',
            'role',
            'is_star',
            'status',
            'instruction',
            'createtime:datetime',
        ],
    ]) ?>

</div>
