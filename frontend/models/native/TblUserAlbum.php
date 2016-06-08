<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_user_album".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $title
 * @property string $url
 * @property string $desc
 * @property integer $status
 * @property integer $createtime
 */
class TblUserAlbum extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_user_album';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'title', 'url', 'desc', 'status', 'createtime'], 'required'],
            [['uid', 'status', 'createtime'], 'integer'],
            [['title', 'url'], 'string', 'max' => 128],
            [['desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '用户id',
            'title' => '标题',
            'url' => '路径',
            'desc' => '简介',
            'status' => '状态',
            'createtime' => '创建时间',
        ];
    }
}
