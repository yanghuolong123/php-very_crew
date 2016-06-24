<?php

namespace app\components\crop;

class CropAsset extends \yii\web\AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugin/jcrop/css/jquery.Jcrop.css',
    ];
    public $js = [
        'plugin/jcrop/js/jquery.Jcrop.js',
    ];
    public $depends = [
        'app\assets\AppAsset',
    ];

}
