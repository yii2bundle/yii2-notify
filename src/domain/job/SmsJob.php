<?php

namespace yii2lab\notify\domain\job;

use App;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii2lab\notify\domain\entities\SmsEntity;
use yii2lab\notify\domain\enums\SmsStatusEnum;

class SmsJob extends BaseObject implements JobInterface {

	public $queue_id;
	public $address;
	public $content;
	
	public function execute($queue) {
        $smsEntity = new SmsEntity;
        $smsEntity->id = $this->queue_id;
        $smsEntity->address = $this->address;
        $smsEntity->content = $this->content;
        App::$domain->notify->repositories->sms->send($smsEntity);
        App::$domain->notify->smsQueue->updateStatus($this->queue_id, SmsStatusEnum::SENDED);
	}
}
