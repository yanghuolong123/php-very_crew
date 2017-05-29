<?php

namespace app\controllers;

use Yii;
use app\models\extend\User;
use app\models\extend\UserProfile;
use app\models\extend\VideoUser;
use yii\helpers\Html;
use yii\helpers\Url;
use app\util\HttpUtil;

class UserController extends \yii\web\Controller {

    public function actionIndex() {
        $searchModel = new \app\models\search\UserSearch();
        $searchModel->status = 1;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['id' => SORT_DESC]];
        $dataProvider->pagination->pageSize = 30;

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        $model = User::findOne($id);
        if (empty($model)) {
            throw new \yii\web\NotFoundHttpException('user not exist!');
        }
        $profie = UserProfile::findOne(['uid' => $id]);
        $videoArr = VideoUser::find()->select('video_id')->where(['uid'=>$id])->column();
        $perVideo = \app\models\extend\Video::find()->where(['in', 'id', $videoArr])->andWhere(['>', 'status', 0])->orderBy('createtime desc')->limit(8)->all();
        $albums = \app\models\extend\UserAlbum::find()->where(['uid' => $id, 'status' => 0])->orderBy('createtime desc')->all();

        return $this->render('view', [
                    'model' => $model,
                    'profile' => empty($profie) ? new UserProfile() : $profie,
                    'perVideo' => $perVideo,
                    'albums' => $albums,
        ]);
    }

    public function actionModifyPasswd($id) {
        $model = User::findOne($id);
        if (empty($model)) {
            throw new \yii\web\NotFoundHttpException('user not exist!');
        }

        $model->setScenario('modifyPassword');

        $beforePassword = '';
        if ($model->load(Yii::$app->request->post())) {
            $beforePassword = $model->password;
            if ($model->validate()) {
                $model->password = md5($model->password);
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('modifyPasswordSuccess');
                }
            }
        }

        $model->password = !empty($beforePassword) ? $beforePassword : '';
        return $this->render('modifyPasswd', [
                    'model' => $model,
        ]);
    }

    public function actionRetrievePassword() {
        $model = new User();
        $model->setScenario('retrievePassword');

        if ($model->load(Yii::$app->request->post())) {
            $code = md5($model->username . date('Y-m-d') . HttpUtil::getClientUserIp());
            $msg = '您好，' . $model->username . ":<br/><br/>";
            $msg .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 我们收到一个您希望通过电子邮件重新设置您在 非常剧组 的帐号密码的请求。您可以点击下面的链接重设密码： ';
            $msg .= Html::a("重置密码", Url::to(['user/reset-password', 'username' => $model->username, 'code' => $code], true));
            $msg .= " <br/><br/><br/>如果这个请求不是由您发起的，那没问题，您不用担心，您可以安全地忽略这封邮件。如果您有任何疑问，可以回复这封邮件向我们提问。谢谢！";

            Yii::$app->mailer->compose()
                    ->setTo($model->email)
                    ->setFrom(['yhl27ml@163.com' => '非常剧组'])
                    ->setSubject("非常剧组-找回密码")
                    ->setHtmlBody($msg, 'text/html')
                    ->send();

            Yii::$app->redis->SET(\app\util\Constant::RetrievePassword . $model->username, $code);
            Yii::$app->redis->EXPIRE(\app\util\Constant::RetrievePassword . $model->username, 3600);
            Yii::$app->session->setFlash('retrievePasswordHasSendEmail');
        }

        return $this->render('retrievePassword', [
                    'model' => $model,
        ]);
    }

    public function actionResetPassword($username, $code) {
        $cacheCode = Yii::$app->redis->GET(\app\util\Constant::RetrievePassword . $username);
        if (empty($cacheCode) || $cacheCode != md5($username . date('Y-m-d') . HttpUtil::getClientUserIp())) {
            Yii::$app->session->setFlash('resetPassword', false);
        }

        $model = User::findOne(['username' => $username]);
        if (empty($model)) {
            throw new \yii\web\NotFoundHttpException('用户名(邮箱/手机号)不正确!');
        }

        $model->setScenario('resetPassword');

        $beforePassword = '';
        if ($model->load(Yii::$app->request->post())) {
            $beforePassword = $model->password;
            if ($model->validate()) {
                $model->password = md5($model->password);
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('resetPassword', true);
                }
            }
        }

        $model->password = !empty($beforePassword) ? $beforePassword : '';
        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

}
