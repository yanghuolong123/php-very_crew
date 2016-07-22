<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'id' => 'search_user_video',
        'action' => ['user-search'],
//        'method' => 'get',
        'options' => ['class' => 'form-horizontal'],
//        'fieldConfig' => [
//            'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
//            'labelOptions' => ['class' => 'col-lg-2 control-label'],
//        ],
    ]); ?>

    <div class="form-group field-usersearch-nickname">
        <label for="usersearch" class="col-lg-2 control-label">姓名/ID</label>
        <div class="col-lg-4"><input type="text" name="search" class="form-control" id="usersearch"></div>        
    </div>
    
    <div class="form-group">
        <div class="col-sm-1 col-md-offset-2 col-md-2">
        <?= Html::hiddenInput('video_id', $_GET['video_id']) ?>
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div id='search-user-content'></div>

<?php $this->beginBlock('userSearchJs') ?> 

$(function() {  
    $('#search_user_video').on('beforeSubmit', function (e) {
        var $form = $(this);
        $.ajax({
            url: $form.attr('action'),
            type: 'post',
            data: $form.serialize(),
            success: function (data) {
                // do something
                $('#search-user-content').html(data);
            }
        });
    }).on('submit', function (e) {
        e.preventDefault();
    });
    
});

<?php $this->endBlock() ?> 
<?php $this->registerJs($this->blocks['userSearchJs'], \yii\web\View::POS_END); ?>