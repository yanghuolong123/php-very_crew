<?php

$this->title = '作品上传';
$this->params['breadcrumbs'][] = ['label' => '我的作品', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-create">
    <div class="btn-group btn-group-justified" style="width: 80%;margin:0 0 20px 80px;" role="group" aria-label="...">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-success">第一步、上传基本信息</button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-warning">第二步、关联作品成员</button>
        </div>
    </div>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
