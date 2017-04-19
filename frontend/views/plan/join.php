<?php

//use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\extend\MetaData;


$this->title = '加入拍摄计划';
$this->params['breadcrumbs'][] = ['label' => '拍摄计划', 'url' => ['view', 'id'=>$plan_id]];
$this->params['breadcrumbs'][] = $this->title;
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

<div class="plan-form">

    <?php $form = ActiveForm::begin([
        'id' => 'plan-user-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>
    
    <?= $form->field($model, 'role')->dropDownList(MetaData::getGroupList('planRole'),['prompt'=>'请选择']) ?>
    
    <?= $form->field($model, 'instruction')->textarea(['rows' => 6]) ?>    

    <?= $form->field($model, 'uid', ['template' => "{input}"])->hiddenInput(['value'=>Yii::$app->user->id]) ?>
    
    <?= $form->field($model, 'plan_id', ['template' => "{input}"])->hiddenInput(['value'=>$plan_id]) ?>
   
    <div class="form-group">
        <div class="col-sm-1 col-md-offset-2">
        <?= Html::submitButton('确定', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php endif; ?>
