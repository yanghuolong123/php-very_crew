<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\extend\MetaData;
use app\models\extend\User;
use app\models\extend\Distrinct;

$this->title = '搭档搜索';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if(!empty($dataProvider->models)): ?>
    <div class="row">
        <div class="container"><h3>搭档搜索</h3></div>
        <?php foreach ($dataProvider->models as $user): ?>
        <div class="col-sm-6 col-md-3">
          <div class="thumbnail">
            <a href="<?= Url::to(['user/view', 'id'=>$user->id]) ?>"><img src="<?= User::getInfo($user->id)->avatar ?>" alt="<?= User::getInfo($user->id)->nickname ?>"></a>
            <div class="caption">
              <h3><a href="<?= Url::to(['user/view', 'id'=>$user->id]) ?>"><?= User::getInfo($user->id)->nickname ?></a></h3>
              <p><?= empty($user->profile['province']) ? "<br>" : implode(' ',Distrinct::getArrDistrict([$user->profile['province'], $user->profile['city'], $user->profile['county'], $user->profile['country']])) ?></p>              
              <?php if(!Yii::$app->user->isGuest): ?>
              <p><a class="btn btn-default" href="<?= Url::to(['plan/invitation', 'uid'=>$user->id]) ?>">将其添加到我的计划备选人员 &raquo;</a></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <div class="alert alert-info">
            <h3>没有搜索到相关搭档...</h3>
        </div>
    <?php endif; ?>
    
    <?= \yii\widgets\LinkPager::widget([
        'pagination' => $dataProvider->pagination,
    ]);
    ?>
    
</div>
