<?php

namespace yii2lab\notify\api\controllers;

use Yii;
use yii2lab\notify\domain\enums\TypeEnum;
use yii2lab\rest\domain\rest\ActiveControllerWithQuery as Controller;
use yii2rails\extension\web\helpers\Behavior;

class TestController extends Controller
{

    public $service = 'notify.test';

    public function init()
    {
        Yii::$app->queue->run(false);
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'cors' => Behavior::cors(),
            'authenticator' => Behavior::auth(['create', 'update', 'delete']),
            //'access' => Behavior::access(GeoPermissionEnum::CITY_MANAGE, ['create', 'update', 'delete']),
        ];
    }

    public function actionClean() {
        \App::$domain->notify->test->truncate(TypeEnum::SMS);
    }

}
