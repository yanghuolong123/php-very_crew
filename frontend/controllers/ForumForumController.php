<?php

namespace app\controllers;

use Yii;
use app\models\extend\ForumForum;
use app\models\search\ForumThreadSearch;

class ForumForumController extends \app\util\BaseController {

    public function actionIndex() {
        $forums = ForumForum::find()->where(['status' => 0])->orderBy('sort asc')->all();
        $searchModel = new ForumThreadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['recommand' => SORT_DESC, 'recommand_time'=>SORT_DESC]];
        $dataProvider->pagination->pageSize = 12;
        
        return $this->render('index', [
                    'forums' => $forums,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}
