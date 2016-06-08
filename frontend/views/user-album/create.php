<?php

use yii\helpers\Html;


$this->title = '上传照片';
$this->params['breadcrumbs'][] = ['label' => '我的照片', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-album-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
