<?php

$this->title = '名次及奖项公布';
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view','id'=>$model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <?php if(!empty($model->result)): ?>
    <div class="col-md-12"><p><?= $model->result ?></p></div>
    <?php else: ?>
    <div class="alert alert-info">
        <h3>比赛结果还为揭晓...</h3>
    </div>
    <?php endif; ?>
</div>