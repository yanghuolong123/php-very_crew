<?php

namespace app\components\comment;

class CommentAsset extends \yii\web\AssetBundle {

    public $sourcePath = '@app/components/comment/assets';
    public $css = [
        'comment.css',
    ];
    public $js = [
        'comment.js',
    ];
    public $depends = [
        'app\assets\AppAsset',
    ];

}
