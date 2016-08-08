<?php 
use app\models\extend\Distrinct;
use app\models\extend\User;
use yii\helpers\Url;
use app\util\CommonUtil;
?>
<?php if(empty($userModel)): ?>
<div class="alert alert-info">没有搜索到匹配的成员</div>
<?php else: ?>
<div class="row">
    <div class="container"><h3>搜索到的成员</h3></div>
    <?php foreach ($userModel as $user): ?>
    <div class="col-sm-6 col-md-3">
      <div class="thumbnail">
          <a href="<?= Url::to(['user/view', 'id'=>$user->id]) ?>"><img src="<?= CommonUtil::cropImgLink(User::getInfo($user->id)->avatar,250,250) ?>" alt="<?= User::getInfo($user->id)->nickname ?>"></a>
        <div class="caption">
          <h4><a href="<?= Url::to(['user/view', 'id'=>$user->id]) ?>"><?= User::getInfo($user->id)->nickname ?></a></h4>
          <p><?= implode(' ',Distrinct::getArrDistrict([$user->profile['province'], $user->profile['city'], $user->profile['county'], $user->profile['country']])) ?></p>              
          <p><a class="btn btn-default" href="<?= Url::to(['video-user/create', 'uid'=>$user->id, 'video_id'=>$video_id]) ?>">添加他为我的作品成员 &raquo;</a></p>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>