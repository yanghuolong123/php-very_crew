<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\extend\ForumForum */

$this->title = 'Update Forum Forum: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Forum Forums', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="forum-forum-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
