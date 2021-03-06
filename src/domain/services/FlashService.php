<?php

namespace yii2lab\notify\domain\services;

use yii2rails\domain\services\base\BaseActiveService;
use yii2bundle\navigation\domain\widgets\Alert;
use yii2lab\notify\domain\entities\FlashEntity;

/**
 * Class FlashService
 *
 * @package yii2lab\notify\domain\services
 * @deprecated use yii2bundle\navigation\domain\services\FlashService
 */
class FlashService extends BaseActiveService {
	
	public function send($content, $type = Alert::TYPE_SUCCESS, $delay = FlashEntity::DELAY_DEFAULT) {
		$entity = $this->repository->forgeEntity([
			'type' => $type,
			'content' => $content,
			'delay' => $delay,
		]);
		$this->repository->send($entity);
	}
	
	public function fetch() {
		return $this->repository->fetch();
	}
	
}
