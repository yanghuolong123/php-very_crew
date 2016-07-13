<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\extend\PlanUser */

$this->title = 'Create Plan User';
$this->params['breadcrumbs'][] = ['label' => 'Plan Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
