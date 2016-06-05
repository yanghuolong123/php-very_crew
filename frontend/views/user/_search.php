<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\extend\MetaData;
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'nickname') ?>
    
    <?= $form->field($model, 'profile[gender]')->radioList(MetaData::getGroupList('gender'))->label("性别") ?>

    <div class="form-group">
        <div class="col-sm-offset-2">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
