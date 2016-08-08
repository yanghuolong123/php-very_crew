<?php
//use Yii;

$this->title = '消息提醒';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= app\components\skip\SkipWidget::widget(['seconds' => 5, 'skipUrl' => Yii::$app->request->referrer, 'msg' => isset($_GET['msg']) ? $_GET['msg'] : '']) ?>
