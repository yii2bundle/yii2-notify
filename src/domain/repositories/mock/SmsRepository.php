<?php

namespace yii2lab\notify\domain\repositories\mock;

use Yii;
use yii\helpers\ArrayHelper;
use yii2lab\domain\repositories\BaseRepository;
use yii2lab\domain\values\TimeValue;
use yii2lab\notify\domain\entities\SmsEntity;
use yii2lab\notify\domain\entities\TestEntity;
use yii2lab\notify\domain\interfaces\repositories\SmsInterface;

class SmsRepository extends BaseRepository implements SmsInterface {
	
	public function send(SmsEntity $message) {
		return \App::$domain->notify->test->send(TestEntity::TYPE_SMS, $message->address, null, $message->content);
	}

    public function isDelivered($id, $phone) {
        $timeValue = new TimeValue();
        $timeValue->set(TIMESTAMP);
        return $timeValue;
    }
}