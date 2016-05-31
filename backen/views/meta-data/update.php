<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\extend\MetaData */

$this->title = '修改数据字典: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '数据字典', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="meta-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
