<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = '免费注册';
$this->params['breadcrumbs'][] = $this->title;
?>
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
        <?= $form->field($model, 'username')->label('用户名(邮箱/手机号)') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'verifyPassword')->passwordInput() ?>
        <?= $form->field($model, 'nickname')->label('姓名') ?>
        <?=
        $form->field($model, 'verifyCode')->widget(Captcha::className(), [
            'template' => '<div class="row"><div class="col-lg-5">{image}</div><div class="col-lg-6">{input}</div></div>',
        ])
        ?>
        <div class="form-group">
            <div class="col-sm-2 col-lg-offset-2">
            <?= Html::submitButton('注册', ['class' => 'btn btn-primary btn-lg', 'name' => 'register-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
            
</div>
