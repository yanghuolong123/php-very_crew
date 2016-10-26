<?php

$this->title = '名次及奖项公布';
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view','id'=>$model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12"><p><?= $model->result ?></p></div>
</div>