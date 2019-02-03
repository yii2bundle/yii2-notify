<?php

namespace yii2lab\notify\domain\interfaces\services;

use yii2rails\domain\interfaces\services\CrudInterface;

interface TestInterface extends CrudInterface {
	
	public function send($type, $address, $subject, $message);
    public function truncate($type);
}