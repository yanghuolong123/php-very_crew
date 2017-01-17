<?php

use app\models\extend\Distrinct;
use app\util\CommonUtil;

$m = strtolower(substr(strrchr(get_class($model), '\\'), 1));
$ismobile = false;
$optionClass = "form-horizontal";
if (CommonUtil::isMobile()) {
    $ismobile = true;
    $optionClass = "form-group";
}
?>
<?php if(!$ismobile): ?>
<style>
    .district-label{
        padding-right: 25px;
    }
</style>
<?php endif; ?>
<?=

$form->field($model, 'province', [
    'template' => "{label}\n<div class=\"col-lg-2\" style=\"margin-bottom: 5px;\">{input}</div>\n",
    'options' => ['class' => $optionClass],
    'labelOptions' => ['class' => 'col-lg-2 control-label district-label'],
])->dropDownList(Distrinct::getDistrictList(0), [
    'prompt' => '请选择省',
    'onchange' => '
            $.post("index.php?r=district/index&pid="+$(this).val(), function(data){
                $("#' . $m . '-city").html("<option value=\"\">请选择城市</option>").append(data);
                $("#' . $m . '-county").html("<option value=\"\">请选择县</option>");
                $("#' . $m . '-country").html("<option value=\"\">请选择乡</option>");
            });   
        ',
])->label($title)
?>

<?=

$form->field($model, 'city', [
    'template' => "<div class=\"col-lg-2\" style=\"margin-bottom: 5px;\">{input}</div>\n",
    'options' => ['class' => $optionClass],
])->dropDownList(Distrinct::getDistrictList($model->province), [
    'prompt' => '请选择城市',
    'onchange' => '
            $.post("index.php?r=district/index&pid="+$(this).val(), function(data){               
                $("#' . $m . '-county").html("<option value=\"\">请选择县</option>").append(data);
                $("#' . $m . '-country").html("<option value=\"\">请选择乡</option>");
            });   
        ',
])->label(false)
?>

<?php if ($level == 3): ?>
    <?=

    $form->field($model, 'county', [
        'template' => "<div class=\"col-lg-2\">{input}</div>\n<div class=\"col-lg-2\">{error}</div>",
    ])->dropDownList(Distrinct::getDistrictList($model->city), [
        'prompt' => '请选择县',
    ])
    ?>
<?php else: ?>

    <?=

    $form->field($model, 'county', [
        'template' => "<div class=\"col-lg-2\">{input}</div>\n",
        'options' => ['class' => $optionClass],
    ])->dropDownList(Distrinct::getDistrictList($model->city), [
        'prompt' => '请选择县',
        'onchange' => '
            $.post("index.php?r=district/index&pid="+$(this).val(), function(data){               
                $("#' . $m . '-country").html("<option value=\"\">请选择乡</option>").append(data);               
            });   
        ',
    ])
    ?>

    <?=

    $form->field($model, 'country', [
        'template' => "<div class=\"col-lg-2\">{input}</div>\n<div class=\"col-lg-2\">{error}</div>",
    ])->dropDownList(Distrinct::getDistrictList($model->city), [
        'prompt' => '请选择乡',
    ])
    ?>

<?php endif; ?>

