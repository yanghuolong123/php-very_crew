<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\extend\MetaData;


$this->title = '添加到计划备选人员';
$this->params['breadcrumbs'][] = $this->title;

$planList = \app\models\extend\Plan::getPlanList(Yii::$app->user->id);
?>

<div class="plan-form">

    <?php $form = ActiveForm::begin([
        'id' => 'plan-user-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>
    
    <div class="form-group">
        <div class="col-sm-offset-2">  
        <p class="text-warning">添加后建议您主动联系对方沟通合作,并在"我的计划"中对人员进行备注</p>
        </div>
    </div>
    
    <?= $form->field($model, 'plan_id')->dropDownList($planList,['prompt'=>'请选择计划']) ?>
       
    
    <?= Html::activeHiddenInput($model, 'uid')  ?>
    <?= Html::activeHiddenInput($model, 'type')  ?>
    
   
    <div class="form-group">
        <div class="col-sm-offset-2">            
        <?= Html::submitButton('确定', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>