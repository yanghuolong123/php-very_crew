<?php

namespace app\models\extend;

class MetaData extends \app\models\native\TblMetaData {

    public function rules() {
        return [
            [['group_key', 'mkey', 'value', 'sort'], 'required'],
            [['sort', 'status'], 'integer'],
            [['group_key'], 'string', 'max' => 64],
            [['mkey'], 'string', 'max' => 65],
            [['value'], 'string', 'max' => 128],
        ];
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->status = 1;
        }
        return parent::beforeSave($insert);
    }

    public static function getGroupKeyArr($isArr = true, $key = '') {
        $arr = [
            'gender' => '性别',
            'videoType' => '视频类型',
            'planRole' => '角色',
            'planSkill' => '特长及形象',
            'videoTag' => '标签',
            'usingTime' => '可用时间',
        ];

        return $isArr ? $arr : (isset($arr[$key]) ? $arr[$key] : '');
    }

}
