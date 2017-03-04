<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\extend\ForumForum;
?>

<div class="forum-thread-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-lg-2\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'fid')->dropDownList(ForumForum::getForumArrayList(), ['prompt' => '请选择']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
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


    <div class="form-group">
        <div class="col-sm-1 col-md-offset-1">
        <?= Html::submitButton($model->isNewRecord ? '发表' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success btn-lg' : 'btn btn-primary btn-lg']) ?>
        </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
