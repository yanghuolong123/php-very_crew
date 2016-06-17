<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\extend\VideoUser */

$this->title = 'Update Video User: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Video Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="video-user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
