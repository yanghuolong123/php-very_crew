<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_article".
 *
 * @property integer $id
 * @property string $groop_key
 * @property string $title
 * @property string $content
 * @property integer $sort
 * @property integer $status
 * @property integer $createtime
 */
class TblArticle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['groop_key', 'title', 'content', 'sort', 'status', 'createtime'], 'required'],
            [['content'], 'string'],
            [['sort', 'status', 'createtime'], 'integer'],
            [['groop_key'], 'string', 'max' => 65],
            [['title'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'groop_key' => '分组',
            'title' => '标题',
            'content' => '内容',
            'sort' => '排序',
            'status' => '状态',
            'createtime' => '创建时间',
        ];
    }
}
