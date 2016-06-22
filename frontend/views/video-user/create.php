<?php

use yii\helpers\Html;


$this->title = '添加他为作品成员';
//$this->params['breadcrumbs'][] = ['label' => '成员管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-user-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
