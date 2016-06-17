<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\extend\VideoUser */

$this->title = 'Create Video User';
$this->params['breadcrumbs'][] = ['label' => 'Video Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
