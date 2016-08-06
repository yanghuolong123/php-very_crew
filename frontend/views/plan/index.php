<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\extend\MetaData;
use app\models\extend\Distrinct;
use app\util\CommonUtil;

$this->title = '计划搜索';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-index">

    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?php if(!empty($dataProvider->models)): ?>
    <div class="row">
        <div class="container"><h3>最新计划</h3></div>
        <?php foreach ($dataProvider->models as $plan): ?>
        <div class="col-sm-6 col-md-4">
          <div class="thumbnail" style="height:272px;">

            <div class="caption">
                <h4><a data-toggle="tooltip" data-placement="bottom" title="<?= $plan->title ?>" href="<?= Url::to(['plan/view', 'id'=>$plan->id]) ?>"><?= CommonUtil::cutstr($plan->title,30) ?></a></h4>
                <p><?= MetaData::getVal($plan->type) ?>  - <?= CommonUtil::cutstr(implode(', ',MetaData::getArrVal(explode(',', trim($plan->tag)))),40) ?></p>  
                <p>拍摄地区：<?= implode(' ',Distrinct::getArrDistrict([$plan->province, $plan->city, $plan->county])) ?></p>
                <p>所需角色：<?= CommonUtil::cutstr(implode(', ',MetaData::getArrVal(explode(',', trim($plan->plan_role)))), 40) ?></p>
                <p>所需演技：<?= CommonUtil::cutstr(implode(', ',MetaData::getArrVal(explode(',', trim($plan->plan_skill)))), 38) ?></p>
                <p>剧情简介：<?= CommonUtil::cutstr($plan->content, 125) ?></p>
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
