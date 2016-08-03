<?php

use yii\helpers\Url;
use app\models\extend\User;
use app\models\extend\Distrinct;
use app\util\CommonUtil;

$this->title = '人员搜索';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if(!empty($dataProvider->models)): ?>
    <div class="row">
        <div class="container"><h3>人员搜索</h3></div>
        <?php foreach ($dataProvider->models as $user): ?>
        <div class="col-sm-6 col-md-2">
          <div class="thumbnail">
            <a href="<?= Url::to(['user/view', 'id'=>$user->id]) ?>"><img src="<?= CommonUtil::cropImgLink(User::getInfo($user->id)->avatar, 160, 160) ?>" alt="<?= User::getInfo($user->id)->nickname ?>"></a>
            <div class="caption">
              <h3><a href="<?= Url::to(['user/view', 'id'=>$user->id]) ?>"><?= User::getInfo($user->id)->nickname ?></a></h3>
              <p><?= empty($user->profile['province']) ? "<br>" : CommonUtil::cutstr(implode(' ',Distrinct::getArrDistrict([$user->profile['province'], $user->profile['city'], $user->profile['county'], $user->profile['country']])), 18) ?></p>              
              <?php if(!Yii::$app->user->isGuest): ?>
              <p><a class="" href="<?= Url::to(['plan/invitation', 'uid'=>$user->id]) ?>">将其添加到我的计划备选人员 &raquo;</a></p>
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
