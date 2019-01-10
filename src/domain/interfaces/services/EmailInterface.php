<?php

namespace yii2lab\notify\domain\interfaces\services;

use yii2lab\domain\interfaces\services\CrudInterface;
use yii2lab\notify\domain\entities\EmailEntity;

interface EmailInterface extends CrudInterface {
	
	public function sendEntity(EmailEntity $emailEntity);
	public function directSendEntity(EmailEntity $emailEntity);
	
	/**
	 * @param $address
	 * @param $subject
	 * @param $content
	 *
	 * @return mixed
	 *
	 * @deprecated
	 */
	public function send($address, $subject, $content);
	
	/**
	 * @param $address
	 * @param $subject
	 * @param $content
	 *
	 * @return mixed
	 *
	 * @deprecated
	 */
	public function directSend($address, $subject, $content);
	
}