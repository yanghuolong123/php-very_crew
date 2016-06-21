<?php

namespace app\components\skip;

class SkipAsset extends \yii\web\AssetBundle {

    public $sourcePath = '@app/components/skip/assets';
    public $css = [
        'skipBack.css',
    ];
    public $js = [
        'skipBack.js',
    ];
    public $depends = [
        'app\assets\AppAsset',
    ];

}
