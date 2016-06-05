<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="image/logo.png" />',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => [
            ['label' => '首页', 'url' => ['/home/index']],
            ['label' => '上传作品', 'url' => ['/video/create']], 
            ['label' => '发布计划', 'url' => ['/plan/create']],
            ['label' => '参与比赛', 'url' => ['/game']],
            ['label' => '搜作品', 'url' => ['/video/index']],
            ['label' => '找搭档', 'url' => ['/user/index']],
            ['label' => '加入拍摄', 'url' => ['/plan/index']],
        ],
    ]);
    
    echo Nav::widget([
        'options' => ['class' =>'navbar-nav navbar-right'],
        'items' => [
            [
                'label' => !Yii::$app->user->isGuest ? '<img class="avatar" src="'.Yii::$app->user->identity->avatar.'">  '.Yii::$app->user->identity->nickname : '',
                'visible' => !Yii::$app->user->isGuest,
                'encode' => false,
                'linkOptions' => ['class'=>'avatar'],
                'items' => [
                     ['label' => '我的资料', 'url' => ['user-profile/view', 'uid'=>Yii::$app->user->id]],
                     ['label' => '我的计划', 'url' => ['plan/my']],
                     ['label' => '我的作品', 'url' => ['video/my']],
                     '<li class="divider"></li>',
                     '<li>'
                    . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                    . Html::submitButton(
                          '安全退出',
                          ['class' => 'btn btn-link']
                      )
                    . Html::endForm()
                    .'</li>',
                ],
            ],
            [
                'label' => '登录',
                'url' => ['site/login'],
                'visible' => Yii::$app->user->isGuest,
            ],
            [
                'label' => '注册',
                'url' => ['site/register'],
                'visible' => Yii::$app->user->isGuest,
            ],
        ],

    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; 非常剧组 <?= date('Y') ?></p>

        <p class="pull-right">Powered by <a href="http://www.womem.cn/" rel="external">远古神龙</a></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
