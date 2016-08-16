<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\extend\MetaData;


$this->title = '添加到计划备选人员';
$this->params['breadcrumbs'][] = $this->title;

$planList = \app\models\extend\Plan::getPlanList(Yii::$app->user->id);
?>

<?php if (Yii::$app->session->hasFlash('hasJoin')): ?>
    <?php if(Yii::$app->session->getFlash('hasJoin') == 0):  ?>
        <div class="alert alert-warning">
            <h2>亲，您已经成功加入了此拍摄计划，请主动联系计划发起人进行沟通。</h2>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">
            <h2>亲，计划发起人已经删除您的申请，如果有疑问请主动联系发起人。</h2>
        </div>
    <?php endif; ?>
<?php else: ?>

<div class="plan-form container">

    <?php $form = ActiveForm::begin([
        'id' => 'plan-user-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>
    
    <div class="form-group">
        <div class="col-sm-offset-2 col-lg-6">  
        <p class="text-warning">添加后建议您主动联系对方沟通合作,并在"我的计划"中对人员进行备注</p>
        </div>
    </div>
    
    <?= $form->field($model, 'plan_id')->dropDownList($planList,['prompt'=>'请选择计划']) ?>
       
    
    <?= Html::activeHiddenInput($model, 'uid')  ?>
    <?= Html::activeHiddenInput($model, 'type')  ?>
    
   
    <div class="form-group">
        <div class="col-sm-1 col-md-offset-2">            
        <?= Html::submitButton('确定', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php endif; ?>