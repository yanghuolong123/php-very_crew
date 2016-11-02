<?php

namespace app\models\search;

class GameVideoSearch extends \app\models\extend\GameVideo {

    public function rules() {
        return [
            [['id', 'score', 'votes', 'createtime'], 'integer'],
            [['remark'], 'safe'],
        ];
    }

}
