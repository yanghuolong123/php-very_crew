<?php

use yii\helpers\Html;

$this->title = '编辑加入作品人员' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '管理加入成员', 'url' => ['index', 'video_id' => $model->video_id]];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="video-user-update">


    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
