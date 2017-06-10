<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\util\Constant;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CommonController extends Controller {

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world') {
        echo $message . "\n";
    }

    /**
     * php /var/work/work_php/very_crew/frontend/yii common/sendmail > /dev/null
     */
    public function actionSendmail() {
        $len = Yii::$app->redis->LLEN(Constant::VoteEmailList);
        while ($len > 0) {
            $json = json_decode(Yii::$app->redis->RPOP(Constant::VoteEmailList));
            Yii::$app->mailer->compose()
                    ->setTo($json->email)
                    ->setFrom(['yhl27ml@163.com' => '非常剧组'])
                    ->setSubject("非常剧组大赛投票")
                    ->setHtmlBody('欢迎您参加大赛投票，' . Html::a('进行投票', Url::to(['game/email-vote', 'email' => $json->email, 'gameVideoId' => $json->voteId])))
                    ->send();

            --$len;
        }
    }

    /**
     * 更新微信token
     * 
     */
    public function actionUpdateWxToken() {
        $weixin = new \app\modules\weixin\models\Weixin();

        $cache = Yii::$app->cache;
        $cache->delete('access_token_' . $weixin->appid);
        $cache->delete('jsapi_ticket_' . $weixin->appid);
        echo "已清除掉 微信 access_token, jsap_ticket 缓存!\n";

        $accessToken = $weixin->getAccessToken();
        $cache->set('access_token_' . $weixin->appid, $accessToken, 3600);
        echo "accessToken:" . $accessToken . "\n";

        $jssdk = new \app\modules\weixin\models\JSSDK();
        $jssdkTicket = $jssdk->getJsApiTicket();
        $cache->set('jsapi_ticket_' . $weixin->appid, $jssdkTicket, 3600);
        echo "jssdkTicket:$jssdkTicket\n";
    }

}
