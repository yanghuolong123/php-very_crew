<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_forum_thread".
 *
 * @property integer $id
 * @property integer $fid
 * @property string $title
 * @property string $content
 * @property integer $user_id
 * @property integer $views
 * @property integer $posts
 * @property integer $recommand
 * @property integer $recommand_time
 * @property integer $status
 * @property integer $lastpost
 * @property string $lastposter
 * @property integer $createtime
 * @property integer $updatetime
 */
class TblForumThread extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_forum_thread';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fid', 'title', 'content', 'user_id', 'views', 'posts', 'recommand', 'recommand_time', 'status', 'lastpost', 'lastposter', 'createtime', 'updatetime'], 'required'],
            [['fid', 'user_id', 'views', 'posts', 'recommand', 'recommand_time', 'status', 'lastpost', 'createtime', 'updatetime'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 128],
            [['lastposter'], 'string', 'max' => 65],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fid' => '版块',
            'title' => '主题',
            'content' => '内容',
            'user_id' => '用户',
            'views' => '查看数',
            'posts' => '帖子数',
            'recommand' => '推荐',
            'recommand_time' => '推荐时间',
            'status' => '状态',
            'lastpost' => '最后回复',
            'lastposter' => '最后回复人',
            'createtime' => '创建时间',
            'updatetime' => '修改时间',
        ];
    }
}
