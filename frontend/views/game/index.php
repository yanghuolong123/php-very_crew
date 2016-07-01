<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\extend\MetaData;

$this->registerJsFile('@web/js/main.js',['depends'=>['app\assets\AppAsset']]);  

$planList = \app\models\extend\Plan::getPlanList(Yii::$app->user->id);
?>

<div class="video-form">

    <?php $form = ActiveForm::begin([
        'id' => 'video-form',
        'options' => ['enctype' => 'multipart/form-data','class' => 'form-horizontal', 'onsubmit'=>''],
        'fieldClass' => 'app\util\ExtActiveField',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>    

    
    <?= $form->field($model, 'file')->fileInput() ?>   
    <?= $form->field($model, 'file')->imgInput() ?>
    
    <input type="file"  id="picupload-36756859256639507" accept=".jpg,.png,.jpeg,.gif">

    <div class="form-group">
        <div class="col-sm-1 col-md-offset-2">
        <?= Html::submitButton('提交并保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>


