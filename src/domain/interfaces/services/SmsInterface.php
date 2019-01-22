<?php

namespace yii2lab\notify\domain\interfaces\services;

use yii2lab\domain\interfaces\services\CrudInterface;
use yii2lab\domain\values\TimeValue;
use yii2lab\notify\domain\entities\SmsEntity;

interface SmsInterface extends CrudInterface {
	
	public function sendEntity(SmsEntity $smsEntity);
	public function directSendEntity(SmsEntity $smsEntity);
	
	/**
	 * @param $address
	 * @param $content
	 *
	 * @return mixed
	 *
	 * @deprecated
	 */
	public function send($address, $content);
	
	/**
	 * @param $address
	 * @param $content
	 *
	 * @return mixed
	 *
	 * @deprecated
	 */
	public function directSend($address, $content);

    /**
     * @param $id
     * @param $phone
     * @return false|TimeValue
     */
    public function isDelivered($id, $phone);
	
}