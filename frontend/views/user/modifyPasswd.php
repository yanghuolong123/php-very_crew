<?php 

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = '修改密码';
$this->params['breadcrumbs'][] = ['label' => '个人资料', 'url' => ['view', 'id'=>$model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if (Yii::$app->session->hasFlash('modifyPasswordSuccess')): ?>
<div class="alert alert-success">
    <h4>您的密码已经修改成功！</h4>
</div>
<?php else: ?>
<div class="site-register">
     
        <?php
        $form = ActiveForm::begin(['id' => 'register-form',
                    'options' => ['class' => 'form-horizontal'],
                    //'enableAjaxValidation' => true,
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-offset-2 col-lg-6\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-2 control-label'],
                    ],
        ]);
        ?>
        <?= $form->field($model, 'oldPassword')->passwordInput()->label('原密码') ?>
        <?= $form->field($model, 'password')->passwordInput()->label('新密码') ?>
        <?= $form->field($model, 'verifyPassword')->passwordInput() ?>
        <?=
        $form->field($model, 'verifyCode')->widget(Captcha::className(), [
            'template' => '<div class="row"><div class="col-lg-5">{image}</div><div class="col-lg-6">{input}</div></div>',
        ])
        ?>
        <div class="form-group">
            <div class="col-sm-2 col-lg-offset-2">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
            
</div>
<?php endif; ?>

