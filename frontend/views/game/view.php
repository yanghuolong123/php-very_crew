<?php
use yii\helpers\Url;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '参与比赛', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="games-view container">     
    <h3 style="color: #00c66b;"><?= $model->name ?></h3>
    <p><?= $model->content ?></p>
    <p><a class="btn btn-success btn-small" href="<?= Url::toRoute(['video/create', 'game_id'=>$model->id]) ?>" role="button">我要参加 &raquo;</a></p>     
</div>