<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\extend\Article;

/* @var $this yii\web\View */
/* @var $model app\models\extend\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'groop_key')->dropDownList(Article::getGroopKeyArr()) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'content')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model,'content')->widget('kucha\ueditor\UEditor',[
            'clientOptions' => [
                //编辑区域大小
                'initialFrameHeight' => '200',
                //设置语言
                'lang' =>'zh-cn', //中文为 zh-cn
                //定制菜单
//                'toolbars' => [
//                    [
//                        'fullscreen', 'source', 'undo', 'redo', '|',
//                        'fontsize',
//                        'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
//                        'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
//                        'forecolor', 'backcolor', '|',
//                        'lineheight', '|',
//                        'indent', '|'
//                    ],
//                ],
            ]
    ]); ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(Article::getStatusArr()) ?>

    <?php // $form->field($model, 'createtime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
