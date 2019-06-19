<?php

namespace yii2lab\notify\domain;

use yii2rails\domain\enums\Driver;
use yii2rails\app\domain\enums\YiiEnvEnum;

/**
 * Class Domain
 * 
 * @package yii2lab\notify\domain
 *
 * @property-read \yii2lab\notify\domain\interfaces\services\EmailInterface $email
 * @property-read \yii2lab\notify\domain\interfaces\services\SmsInterface $sms
 * @property-read \yii2lab\notify\domain\interfaces\services\TestInterface $test
 * @property-read \yii2lab\notify\domain\interfaces\repositories\RepositoriesInterface $repositories
 * @property-read \yii2lab\notify\domain\interfaces\services\SmsQueueInterface $smsQueue
 */
class Domain extends \yii2rails\domain\Domain {
	
	public function config() {
		return [
			'repositories' => [
				'transport',
				'email' => Driver::YII,
				'sms' => YII_ENV === YiiEnvEnum::PROD ? 'smsc' : Driver::MOCK,
				'flash' => Driver::SESSION,
				'test' => Driver::FILEDB,
                'smsQueue' => Driver::ACTIVE_RECORD,
			],
			'services' => [
				'transport',
				'email',
				'sms',
				'flash',
				'test',
                'smsQueue',
			],
		];
	}
	
}