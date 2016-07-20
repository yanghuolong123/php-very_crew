<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
//        'action' => ['index'],
//        'method' => 'get',
        'options' => ['class' => 'form-horizontal'],
//        'fieldConfig' => [
//            'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
//            'labelOptions' => ['class' => 'col-lg-2 control-label'],
//        ],
    ]); ?>

    <div class="form-group field-usersearch-nickname">
        <label for="usersearch" class="col-lg-2 control-label">姓名/ID</label>
        <div class="col-lg-4"><input type="text" name="userSearch" class="form-control" id="usersearch"></div>        
    </div>
    
    <div class="form-group">
        <div class="col-sm-1 col-md-offset-2 col-md-2">
        <?= Html::button('搜索', ['class' => 'btn btn-primary user-search-bt']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div id='search-user-content'></div>

<?php $this->beginBlock('userSearchJs') ?> 

$(function() {    
    $(".user-search-bt").click(function(){
        var search = $('#usersearch').val();
        $.post("<?= Url::to(['user-search']) ?>",{search:search, video_id:<?= $_GET['video_id'] ?>}, function(data){
            $('#search-user-content').html(data);
        });
    });
});

<?php $this->endBlock() ?> 
<?php $this->registerJs($this->blocks['userSearchJs'], \yii\web\View::POS_END); ?>