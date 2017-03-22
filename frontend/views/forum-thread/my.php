<?php 
 
use app\models\extend\ForumForum; 
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = '我的帖子';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-index">
    
    <div class="table-responsive">
    <?=
        GridView::widget([
            'layout' => "\n{items}\n",
            'tableOptions' => ['class' => 'table'],
            'dataProvider' => $dataProvider,
            'columns' => [
                [

                    'label' => '标题',
                    'format' => 'raw',
                    'value' => function($data) {
                $forum = ForumForum::findOne($data->fid);
                return '[' . Html::a($forum->name, ['forum-thread/index', 'fid' => $forum->id], ['class' => 'forum-link']) . '] ' . Html::a($data->title, ['forum-thread/view', 'id' => $data->id]);
            },
                ],
                
                [
                    'label' => '回复/查看',
                    'value' => function($data) {
                return $data->posts . '/' . $data->views;
            },
                ],
                [
                    'label' => '发表时间',
                    'value' => function($data) {
                return date('Y-m-d H:i:s', $data->createtime);
            },
                ],
            ],
        ]);
        ?>
    </div>
</div>


