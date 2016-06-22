<?php

namespace app\components\skip;

use Yii;
use yii\base\Widget;
use app\components\skip\SkipAsset;

/**
 * Skip Class file
 * 
 * @author: huolong yang<yhl27ml@163.com>
 * @copyright: Copyright &copy; 2011 - 2099
 */
class SkipWidget extends Widget {

    public $seconds = 5;  // $seconds秒倒计时之后页面跳转
    public $skipUrl;    // 要跳转到的urldiz,如不设置默认跳转到首页
    public $msg;     // 倒计时时显示在页面上的信息
    public $closeWindow;  // 如果$closeWindow设置为 ‘yes’的话，当倒计时结束后马上关闭浏览器窗口，而不跳转

    /**
     * 运行
     *      
     */

    public function run() {

        if (empty($this->skipUrl)) {
            $this->skipUrl = Yii::$app->user->returnUrl;
        }
        $view = $this->getView();
        SkipAsset::register($view);

        return $this->render('skip', [
            'msg' => $this->msg,
            'seconds' => $this->seconds,
            'skipUrl' => $this->skipUrl,
            'closeWindow' => $this->closeWindow,
        ]);
    }

}
