<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\extend\ForumThread */

$this->title = 'Create Forum Thread';
$this->params['breadcrumbs'][] = ['label' => 'Forum Threads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forum-thread-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
