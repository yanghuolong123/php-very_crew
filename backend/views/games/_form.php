<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use app\models\extend\Games;


$this->registerJsFile('@web/js/main.js',['depends'=>['app\assets\AppAsset']]);
?>

<div class="games-form">

    <?php $form = ActiveForm::begin([
        'id' => 'games-form',
        'fieldClass' => 'app\util\ExtActiveField',
    ]); ?>

    <?php // $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'logo')->imgInput() ?>

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

    <?= $form->field($model, 'sort')->textInput(['value'=>0]) ?>

    <?= $form->field($model, 'status')->dropDownList(Games::getStatusArr()) ?>
    
    <?=
    $form->field($model, 'begin_time')->widget(
            DatePicker::className(), [
        // inline too, not bad
        'inline' => false,
        'language' => 'zh-CN',
        // modify template for custom rendering
        'template' => '{addon}{input}',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>

    <?=
    $form->field($model, 'end_time')->widget(
            DatePicker::className(), [
        // inline too, not bad
        'inline' => false,
        'language' => 'zh-CN',
        // modify template for custom rendering
        'template' => '{addon}{input}',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>  
    
    <?php // $form->field($model, 'result')->textarea() ?>
    <?= $form->field($model,'result')->widget('kucha\ueditor\UEditor',[
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
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
