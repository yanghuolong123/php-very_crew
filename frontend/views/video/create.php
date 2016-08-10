<?php

$this->title = '作品上传';
$this->params['breadcrumbs'][] = ['label' => '搜作品', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-create">
    <div class="row" style="margin-bottom: 30px; font-size: 16px; font-weight: bold; color:#090;">
        <div class="col-sm-1 col-md-offset-2 col-md-3">
            第一步：上传基本信息
        </div>
        <div class="col-sm-1 col-md-3">
            第二步：关联作品成员(可跳过)
        </div>
    </div>
    

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
