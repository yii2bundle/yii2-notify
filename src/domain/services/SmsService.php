<?php

namespace yii2lab\notify\domain\services;

use Yii;
use yii2lab\notify\domain\entities\SmsQueueEntity;
use yii2lab\notify\domain\enums\SmsStatusEnum;
use yii2rails\domain\services\base\BaseActiveService;
use yii2rails\extension\enum\enums\TimeEnum;
use yii2lab\notify\domain\entities\SmsEntity;
use yii2lab\notify\domain\exceptions\SmsTimeLimitException;
use yii2lab\notify\domain\interfaces\services\SmsInterface;
use yii2lab\notify\domain\job\SmsJob;

/**
 * Class SmsService
 *
 * @package yii2lab\notify\domain\services
 *
 * @property \yii2lab\notify\domain\interfaces\repositories\SmsInterface $repository
 */
class SmsService extends BaseActiveService implements SmsInterface {
	
	public $directOnly = false;
	public $timeLimit = TimeEnum::SECOND_PER_MINUTE;
	
	public function sendEntity(SmsEntity $smsEntity) : SmsQueueEntity {
		if($this->directOnly) {
			$this->directSendEntity($smsEntity);
			return null;
		}
		$this->validate($smsEntity);
        $smsQeueEntity = $this->createQueue($smsEntity);
        $smsEntity->id = $smsQeueEntity->id;
		$this->pushJob($smsEntity);
        return $smsQeueEntity;
	}

	public function directSendEntity(SmsEntity $smsEntity) : SmsQueueEntity {
		$this->validate($smsEntity);
        $smsQeueEntity = $this->createQueue($smsEntity);
        $smsEntity->id = $smsQeueEntity->id;
		$this->repository->send($smsEntity);
		\App::$domain->notify->smsQueue->updateStatus($smsQeueEntity->id, SmsStatusEnum::SENDED);
		return $smsQeueEntity;
	}
	
	public function send($address, $content) {
        $smsEntity = new SmsEntity;
        $smsEntity->address = $address;
        $smsEntity->content = $content;
        $smsEntity->format = $format;
	    if($this->directOnly) {
			$this->directSendEntity($smsEntity);
			return null;
		}
        return $this->sendEntity($smsEntity);
	}

	public function directSend($address, $content) {
		$smsEntity = new SmsEntity;
		$smsEntity->address = $address;
		$smsEntity->content = $content;
        return $this->directSendEntity($smsEntity);
	}

    public function isDelivered($id, $phone) {
        return $this->repository->isDelivered($id, $phone);
    }

    private function createQueue(SmsEntity $smsEntity) {
        $smsQeueEntity = new SmsQueueEntity;
        $smsQeueEntity->phone = $smsEntity->address;
        $smsQeueEntity->content = $smsEntity->content;
        $smsQeueEntity->format = $smsEntity->format;
        \App::$domain->notify->repositories->smsQueue->insert($smsQeueEntity);
        return $smsQeueEntity;
    }

    /** @deprecated */
	private function validate(SmsEntity $smsEntity) {
		$smsEntity->validate();
		/*$key = 'SmsTimeLimit_' . $smsEntity->address;
		$isHas = Yii::$app->cache->get($key);
		if($isHas) {
			throw new SmsTimeLimitException;
		}
		Yii::$app->cache->set($key, TIMESTAMP, $this->timeLimit);*/
	}

    private function createJob(SmsEntity $smsEntity) {
        $job = new SmsJob;
        $job->queue_id = $smsEntity->id;
        $job->address = $smsEntity->address;
        $job->content = $smsEntity->content;
        $job->format = $smsEntity->format;
        return $job;
    }

    private function pushJob(SmsEntity $smsEntity) {
		$job = $this->createJob($smsEntity);
		$jobId = Yii::$app->queue->push($job);
		return $jobId;
	}
}
