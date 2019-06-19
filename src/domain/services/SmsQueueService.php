<?php

namespace yii2lab\notify\domain\services;

use yii2lab\notify\domain\interfaces\services\SmsQueueInterface;
use yii2rails\domain\services\base\BaseActiveService;

/**
 * Class SmsQueueService
 * 
 * @package yii2lab\notify\domain\services
 * 
 * @property-read \yii2lab\notify\domain\Domain $domain
 * @property-read \yii2lab\notify\domain\interfaces\repositories\SmsQueueInterface $repository
 */
class SmsQueueService extends BaseActiveService implements SmsQueueInterface {

}
