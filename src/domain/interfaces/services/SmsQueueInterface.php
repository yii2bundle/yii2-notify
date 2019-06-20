<?php

namespace yii2lab\notify\domain\interfaces\services;

use yii2rails\domain\interfaces\services\CrudInterface;

/**
 * Interface SmsQueueInterface
 * 
 * @package yii2lab\notify\domain\interfaces\services
 * 
 * @property-read \yii2lab\notify\domain\Domain $domain
 * @property-read \yii2lab\notify\domain\interfaces\repositories\SmsQueueInterface $repository
 */
interface SmsQueueInterface extends CrudInterface {

    public function checkAllStatus();

}
