<?php

use dosamigos\datepicker\DatePicker;
use app\util\CommonUtil;

$ismobile = false;
$optionClass = "form-horizontal";
if (CommonUtil::isMobile()) {
    $ismobile = true;
    $optionClass = "form-group";
}
?>

<?php if (!$ismobile): ?>
    <style>
        .begin_time_label{
            padding-right: 25px;
        }
        .tpl_begin{
            
        }
    </style>
<?php endif; ?>


<?=

$form->field($model, 'begin_time', [
    'template' => "{label}\n<div class=\"col-lg-3\" style=\"padding-left: 5px;margin-bottom: 5px;\">{input}</div>\n",
    'options' => ['class' => $optionClass],
    'labelOptions' => ['class' => 'col-lg-2 control-label begin_time_label'],
])->widget(
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

$form->field($model, 'end_time', [
    'template' => "{label}\n<div class=\"col-lg-3\" style=\"padding-left: 5px;margin-bottom: 5px;\">{input}</div><div class=\"col-lg-2\">{error}</div>\n",
    //'options' => ['class' => 'form-horizontal'],
    'labelOptions' => ['class' => 'col-lg-1 control-label'],
])->widget(
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