<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\extend\MetaData;


$this->title = '邀请他加入拍摄计划';
$this->params['breadcrumbs'][] = $this->title;

$planList = \app\models\extend\Plan::getPlanList(Yii::$app->user->id);
?>

<?php if (Yii::$app->session->hasFlash('hasJoin')): ?>
    <?php if(Yii::$app->session->getFlash('hasJoin') == 0):  ?>
        <div class="alert alert-warning">
            <h2>亲，您已经申请加入了此拍摄计划，请等待计划发起人审核。</h2>
        </div>
    <?php elseif(Yii::$app->session->getFlash('hasJoin') == 1): ?>
        <div class="alert alert-info">
            <h2>亲，计划发起人已经审核通过你的申请，您已经是此计划的成员。</h2>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">
            <h2>亲，计划发起人经过审核你的申请，已确认你不适合加入此计划。</h2>
        </div>
    <?php endif; ?>
<?php else: ?>

<div class="plan-form">

    <?php $form = ActiveForm::begin([
        'id' => 'plan-user-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>
    
    <?= $form->field($model, 'plan_id')->dropDownList($planList,['prompt'=>'请选择计划']) ?>
    
    <?= $form->field($model, 'desc')->textarea(['rows' => 6]) ?> 
    
    <?= Html::activeHiddenInput($model, 'uid')  ?>
    <?= Html::activeHiddenInput($model, 'type')  ?>
    
   
    <div class="form-group">
        <div class="col-sm-offset-2">
        <?= Html::submitButton('确定', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php endif; ?>
