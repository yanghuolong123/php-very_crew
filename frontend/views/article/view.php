<?php

use yii\helpers\Html;

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= $model->content ?>
    </p>

</div>
