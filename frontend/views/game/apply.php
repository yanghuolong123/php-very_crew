<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\extend\GameApply;

$this->title = "申请资助";
$this->params['breadcrumbs'][] = ['label' => '参加比赛', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $game->name, 'url' => ['view', 'id'=>$game->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php if (!Yii::$app->session->hasFlash('hasApply')): ?>
<div class="game-apply-form">

    <?php $form = ActiveForm::begin([
//        'options' => ['class' => 'form-horizontal'],
//        'fieldConfig' => [
//            'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
//            'labelOptions' => ['class' => 'col-lg-2 control-label'],
//        ],
    ]); ?>
 

    <?= $form->field($model, 'username')->textInput(['maxlength' => true])->label("申请人 (我们会按照申请人个人资料中的联系方式与您联系)默认注册用户名") ?>

    <?= $form->field($model, 'amount')->dropDownList(GameApply::getAmountList(), ['prompt' => '请选择'])->label("申请资助金额") ?>

    <?= $form->field($model, 'summary')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'join_num')->textInput()->label("预计参与拍摄的人数") ?>

    <?= $form->field($model, 'len_minute')->textInput()->label("预计视频时长:分") ?>

    <?= $form->field($model, 'len_second')->textInput()->label("预计视频时长:秒") ?>

    <?= $form->field($model, 'conditions')->textarea(['maxlength' => true])->label("哪些条件能保证您在期限内顺利完成作品？") ?>

    <?= $form->field($model, 'ability')->textarea(['maxlength' => true])->label("拍摄经验/经历/技能") ?>

    <?= $form->field($model, 'advantage')->textarea(['maxlength' => true])->label("其它您认为有利于您获得拍摄资助的说明") ?>

    <div class="form-group">
         
        <?= Html::submitButton( '提交申请', ['class' => 'btn btn-primary']) ?>
         
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php else: ?>
    <div class="alert alert-success">
        <h4>您已经提交成功，我们工作人员会在评估后通知您申请结果。感谢您的参与！</h4>
    </div>
<?php endif; ?>
