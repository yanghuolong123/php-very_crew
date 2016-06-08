<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\extend\UserAlbum */

$this->title = '查看照片: ';
$this->params['breadcrumbs'][] = ['label' => '我的照片', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="user-album-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
