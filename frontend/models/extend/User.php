<?php

namespace app\models\extend;

use app\models\extend\UserProfile;

class User extends \app\models\native\TblUser {

    private static $_user = [];
    public $verifyCode;
    public $verifyPassword;

    public $profile;

    public function rules() {
        return [
            [['username', 'nickname'], 'required'],
            [['password', 'verifyPassword'], 'required', 'on' => 'register'],
            //[['avatar', 'mobile'], 'required', 'on' => 'perfect'],
            [['username', 'mobile', 'email'], 'unique'],
            //[['username', 'email'], 'email'],
            [['username', 'nickname', 'mobile'], 'string', 'max' => 32],
            [['avatar', 'thumb_avatar'], 'string', 'max' => 255],
            ['verifyPassword', 'compare', 'compareAttribute' => 'password', 'on' => 'register'],
            ['verifyCode', 'captcha', 'on' => 'register'],
            ['username', 'validRegister', 'on' => 'register'],
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
        if (is_numeric($this->username)) {
            $this->mobile = $this->username;
        } else {
            $this->email = $this->username;
        }
        $this->createtime = time();

        return $this->insert(false);
    }

    public static function getInfo($id) {
        if (empty(self::$_user[$id])) {
            self::$_user[$id] = self::findOne($id);
            self::$_user[$id]->profile= $this->hasOne(UserProfile::className(), ['uid' => 'id']);
//            if (empty(self::$_user[$id]->profile)) {
//                self::$_user[$id]->profile = new UserProfile();
//            }
        }

        return self::$_user[$id];
    }

    public function getProfile() {
        return $this->hasOne(UserProfile::className(), ['uid' => 'id']);
    }

    public function setProfile($profile) {
        $this->profile = $profile;
    }

    public function afterFind() {
        if (empty($this->avatar)) {
            $this->avatar = '/image/default_avatar.jpg';
        }

//        if (empty($this->thumb_avatar)) {
//            $this->thumb_avatar = './image/default_avatar.jpg';
//        }
        //$this->profile = UserProfile::findOne(['uid' => $this->id]);

        parent::afterFind();
    }

    public function validRegister($attribute, $params) {
        if (!$this->hasErrors()) {

            if (!preg_match("/^1[34578]\d{9}$/", $this->username) && !preg_match("/^[0-9a-zA-Z]+@(([0-9a-zA-Z]+)[.])+[a-z]{2,4}$/i", $this->username)) {
                $this->addError($attribute, '请使用手机号或邮箱注册.');
            }

//            if (preg_match("/^1[34578]\d{9}$/", $this->username) && self::find()->where(['mobile' => $this->username, 'status' => 1])->exists()) {
//                $this->addError($attribute, '该手机号已被注册.');
//            }
//
//            if (preg_match("/^[0-9a-zA-Z]+@(([0-9a-zA-Z]+)[.])+[a-z]{2,4}$/i", $this->username) && self::find()->where(['email' => $this->username, 'status' => 1])->exists()) {
//                $this->addError($attribute, '该邮箱已被注册.');
//            }
        }
    }

}
