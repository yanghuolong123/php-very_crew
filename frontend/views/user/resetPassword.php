<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = '重置密码';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if (Yii::$app->session->hasFlash('resetPassword')): ?>
    <?php if (Yii::$app->session->getFlash('resetPassword')): ?>
        <div class="alert alert-success">
            <h4>重置密码成功！请 <?= Html::a('登录', ['site/login']) ?></h4>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            <h4>链接已失效！请重新 <?= Html::a('找回密码', ['user/retrieve-password']) ?></h4>
        </div>
    <?php endif; ?>
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

        <?= $form->field($model, 'password')->passwordInput()->label('新密码') ?>
        <?= $form->field($model, 'verifyPassword')->passwordInput() ?>
        <?=
        $form->field($model, 'verifyCode')->widget(Captcha::className(), [
            'template' => '<div class="row"><div class="col-lg-5">{image}</div><div class="col-lg-6">{input}</div></div>',
        ])
        ?>
        <div class="form-group">
            <div class="col-sm-2 col-lg-offset-2">
                <?= Html::submitButton('重置密码', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
<?php endif; ?>

