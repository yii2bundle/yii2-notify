<?php

namespace yii2lab\notify\domain\interfaces\repositories;

use yii2lab\domain\values\TimeValue;
use yii2lab\notify\domain\entities\SmsEntity;

interface SmsInterface {
	
	public function send(SmsEntity $message);

    /**
     * @param $id
     * @param $phone
     * @return false|TimeValue
     */
    public function isDelivered($id, $phone);

}