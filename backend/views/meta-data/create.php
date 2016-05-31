<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\extend\MetaData */

$this->title = '创建数据字典';
$this->params['breadcrumbs'][] = ['label' => '数据字典', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meta-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
