<?php

namespace yii2lab\notify\api\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii2lab\notify\domain\entities\SmsEntity;
use yii2lab\notify\domain\enums\NotifyPermissionEnum;
use yii2lab\notify\domain\enums\TypeEnum;
use yii2lab\rest\domain\rest\Controller;
use yii2rails\extension\web\enums\HttpHeaderEnum;
use yii2rails\extension\web\helpers\Behavior;

class SmsController extends Controller
{

    public $service = 'notify.sms';

    /*public function init()
    {
        Yii::$app->queue->run(false);
        parent::init();
    }*/

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            //'cors' => Behavior::cors(),
            'authenticator' => Behavior::auth(),
            'access' => Behavior::access(NotifyPermissionEnum::SMS_SEND),
        ];
    }

    public function actionCreate() {
        $data = Yii::$app->request->post();
        $smsEntity = new SmsEntity($data);
        if(!empty($data['is_direct_send'])) {
            $smsQeueEntity = \App::$domain->notify->sms->directSendEntity($smsEntity);
        } else {
            $smsQeueEntity = \App::$domain->notify->sms->sendEntity($smsEntity);
        }
        Yii::$app->response->headers->add(HttpHeaderEnum::X_ENTITY_ID, $smsQeueEntity->id);
    }

}
