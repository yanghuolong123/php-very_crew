<?php

use yii\helpers\Html;


$this->title = '作品上传';
$this->params['breadcrumbs'][] = ['label' => '我的作品', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
