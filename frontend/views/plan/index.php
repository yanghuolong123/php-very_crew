<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\extend\MetaData;
use app\models\extend\Distrinct;


$this->title = '加入拍摄';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-index">

    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?php if(!empty($dataProvider->models)): ?>
    <div class="row">
        <div class="container"><h3>最新计划</h3></div>
        <?php foreach ($dataProvider->models as $plan): ?>
        <div class="col-sm-6 col-md-4">
          <div class="thumbnail">

            <div class="caption">
                <h3><a href="<?= Url::to(['plan/view', 'id'=>$plan->id]) ?>"><?= $plan->title ?></a></h3>
              <p><?= MetaData::getVal($plan->type) ?>  - <?= implode(', ',MetaData::getArrVal(explode(',', trim($plan->tag)))) ?></p>  
              <p>拍摄地区：<?= implode(' ',Distrinct::getArrDistrict([$plan->province, $plan->city, $plan->county])) ?></p>
              <p>所需角色：<?= implode(', ',MetaData::getArrVal(explode(',', trim($plan->plan_role)))) ?></p>
              <p>所需演技：<?= implode(', ',MetaData::getArrVal(explode(',', trim($plan->plan_skill)))) ?></p>
              <p>剧情简介：<?= $plan->content ?></p>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <div class="alert alert-info">
            <h3>没有搜索到相关计划...</h3>
        </div>
    <?php endif; ?>
    
    <?= \yii\widgets\LinkPager::widget([
        'pagination' => $dataProvider->pagination,
    ]);
    ?>
    
</div>
