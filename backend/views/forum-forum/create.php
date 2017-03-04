<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\extend\ForumForum */

$this->title = 'Create Forum Forum';
$this->params['breadcrumbs'][] = ['label' => 'Forum Forums', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forum-forum-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
