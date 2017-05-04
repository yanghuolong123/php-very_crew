<?php
use yii\helpers\Html;

$this->title = '作品上传';
$this->params['breadcrumbs'][] = ['label' => '搜作品', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$showMsg = '可跳过';
if(isset($_GET['game_id']) && !empty($_GET['game_id'])) {
   $showMsg = '<span style="font-size:12px;">是否关联主要成员是评判是否为新作品的重要依据 '.Html::a('关联技巧', ['forum-thread/view', 'id'=>3]).'</span>'; 
}
?>
<div class="video-create">
    <div class="row" style="margin-bottom: 30px; font-size: 16px; font-weight: bold; color:#090;">
        <div class="col-sm-1 col-md-offset-2 col-md-3">
            第一步：上传基本信息
        </div>
        <div class="col-sm-1 col-md-6">
            第二步：关联作品成员(<?= $showMsg ?>)
        </div>
    </div>
    

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
