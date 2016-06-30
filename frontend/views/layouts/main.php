<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$redis = Yii::$app->redis;
$user_msg = $redis->get('user_msg_'.Yii::$app->user->id);
$user_private_msg = $redis->get('user_private_msg_'.Yii::$app->user->id);
$tips = $user_msg || $user_private_msg ? '<span class="glyphicon glyphicon-volume-up" style="color:red;"></span>' : '';

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
        'brandLabel' => '<img style="height:32px;" src="image/logo.png" />',
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
                'label' => !Yii::$app->user->isGuest ? '<img class="avatar" src="'.Yii::$app->user->identity->avatar.'">  '.Yii::$app->user->identity->nickname.' '.$tips : '',
                'visible' => !Yii::$app->user->isGuest,
                'encode' => false,
                'linkOptions' => ['class'=>'avatar'],
                'items' => [
                     ['label' => '<span class="glyphicon glyphicon-envelope"></span> 我的私信 <span class="tip_num">'.($user_private_msg ? '('.$user_private_msg.')' : '').'</span>', 'url' => ['comment/my-list','type'=>2],'encode' => false],
                     ['label' => '<span class="glyphicon glyphicon-comment"></span> 我的留言 <span class="tip_num">'.($user_msg ? '('.$user_msg.')' : '').'</span>', 'url' => ['comment/my-list', 'type'=>3],'encode' => false],
                     ['label' => '<span class="glyphicon glyphicon-user"></span> 我的资料', 'url' => ['user-profile/view', 'uid'=>Yii::$app->user->id],'encode' => false],
                     '<li class="divider"></li>',
                     ['label' => '我的计划', 'url' => ['plan/my']],
                     ['label' => '我的作品', 'url' => ['video/my']],
                     '<li class="divider"></li>',
                     '<li>'
                    . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                    . Html::submitButton(
                          '<span class="glyphicon glyphicon-log-out"></span> 安全退出',
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
