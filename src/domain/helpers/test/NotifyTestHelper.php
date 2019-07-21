<?php

namespace yii2lab\notify\domain\helpers\test;

use Yii;
use App;
use yii2lab\rest\domain\entities\RequestEntity;
use yii2lab\rest\domain\entities\ResponseEntity;
use yii2lab\test\helpers\RestTestHelper;
use yii2rails\app\domain\helpers\EnvService;
use yii2rails\extension\enum\enums\TimeEnum;
use yii2rails\extension\web\enums\HttpMethodEnum;
use yii\web\NotFoundHttpException;
use yii2lab\notify\domain\entities\SmsEntity;
use yii2lab\notify\domain\entities\TestEntity;
use yii2lab\notify\domain\enums\TypeEnum;
use yii2lab\rest\domain\helpers\RestHelper;
use yii2mod\helpers\ArrayHelper;
use yii2rails\app\domain\helpers\Config;
use yii2rails\app\domain\helpers\Env;
use yii2rails\extension\yii\helpers\FileHelper;
use yii2module\account\domain\v3\helpers\test\AuthTestHelper;

class NotifyTestHelper
{

    public static function cleanSms() {
        AuthTestHelper::authByLogin('admin');
        $requestEntity = new RequestEntity;
        $requestEntity->method = HttpMethodEnum::DELETE;
        $requestEntity->uri = 'v1/notify-test';
        $responseEntity = RestTestHelper::sendRequest($requestEntity);
        AuthTestHelper::loadPrevAuth();
    }

    public static function getActivationCodeByPhone($phone) {
        $smsEntity = self::oneSmsByPhone($phone);
        $code = '';
        if (preg_match('/([0-9]{6})/s', $smsEntity->message, $matches)) {
            $code = $matches[1];
        }
        return $code;
    }

    private static function oneSmsByPhone($phone) : TestEntity {
        AuthTestHelper::authByLogin('admin');
        $requestEntity = new RequestEntity;
        $requestEntity->method = HttpMethodEnum::GET;
        $requestEntity->uri = 'v1/notify-test';
        $requestEntity->data = [
            'type' => TypeEnum::SMS,
        ];
        $responseEntity = RestTestHelper::sendRequest($requestEntity);
        $collection = $responseEntity->data;
        if(empty($collection)) {
            throw new NotFoundHttpException('Sms not found');
        }
        $smsEntity = new TestEntity(ArrayHelper::first($collection));
        AuthTestHelper::loadPrevAuth();
        return $smsEntity;
    }

}
