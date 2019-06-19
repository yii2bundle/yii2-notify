<?php

namespace yii2lab\notify\domain\job;

use App;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii2lab\notify\domain\entities\SmsEntity;

class SmsJob extends BaseObject implements JobInterface {
	
	public $address;
	public $content;
	
	public function execute($queue) {
        $smsEntity = new SmsEntity;
        $smsEntity->address = $address;
        $smsEntity->content = $content;
		App::$domain->notify->sms->directSendEntity($smsEntity);
	}
}
