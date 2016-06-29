<?php

namespace app\models\extend;

use app\models\extend\UserProfile;

class User extends \app\models\native\TblUser {

    private static $_user = [];
    public $verifyCode;
    public $verifyPassword;

    //public $profile;

    public function rules() {
        return [
            [['username', 'nickname'], 'required'],
            [['password', 'verifyPassword'], 'required', 'on' => 'register'],
            [['avatar', 'mobile'], 'required', 'on' => 'perfect'],
            ['username', 'unique'],
            [['username', 'email'], 'email'],
            [['username', 'nickname', 'mobile'], 'string', 'max' => 32],
            [['avatar', 'thumb_avatar'], 'string', 'max' => 255],
            ['verifyPassword', 'compare', 'compareAttribute' => 'password', 'on' => 'register'],
            ['verifyCode', 'captcha', 'on' => 'register'],
        ];
    }

    public function attributeLabels() {
        return array_merge([
            'verifyCode' => '验证码',
            'verifyPassword' => '确认密码',
                ], parent::attributeLabels());
    }

    public function register() {
        $this->password = md5($this->password);
        $this->status = 1;
        $this->email = $this->username;
        $this->createtime = time();

        return $this->insert(false);
    }

    public static function getInfo($id) {
        if (empty(self::$_user[$id])) {
            self::$_user[$id] = self::findOne($id);
        }

        return self::$_user[$id];
    }

    public function getProfile() {
        return $this->hasOne(UserProfile::className(), ['uid' => 'id']);
    }

    public function afterFind() {
        if (empty($this->avatar)) {
            $this->avatar = './image/default_avatar.jpg';
        }

//        if (empty($this->thumb_avatar)) {
//            $this->thumb_avatar = './image/default_avatar.jpg';
//        }

        //$this->profile = UserProfile::findOne(['uid' => $this->id]);

        parent::afterFind();
    }

}
