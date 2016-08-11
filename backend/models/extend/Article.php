<?php

namespace app\models\extend;

class Article extends \app\models\native\TblArticle {

    public function rules() {
        return [
            [['groop_key', 'title', 'content'], 'required'],
            [['content'], 'string'],
            [['sort', 'status', 'createtime'], 'integer'],
            [['groop_key'], 'string', 'max' => 65],
            [['title'], 'string', 'max' => 128],
        ];
    }

}
