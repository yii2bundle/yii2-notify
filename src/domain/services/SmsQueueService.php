<?php

namespace yii2lab\notify\domain\services;

use yii\helpers\ArrayHelper;
use yii2lab\notify\domain\entities\SmsQueueEntity;
use yii2lab\notify\domain\enums\SmsStatusEnum;
use yii2lab\notify\domain\interfaces\services\SmsQueueInterface;
use yii2rails\domain\data\Query;
use yii2rails\domain\services\base\BaseActiveService;

/**
 * Class SmsQueueService
 * 
 * @package yii2lab\notify\domain\services
 * 
 * @property-read \yii2lab\notify\domain\Domain $domain
 * @property-read \yii2lab\notify\domain\interfaces\repositories\SmsQueueInterface $repository
 */
class SmsQueueService extends BaseActiveService implements SmsQueueInterface {

    public function checkAllStatus() {
        $query = new Query;
        $query->andWhere([
            'and',
            ['>=', 'status', SmsStatusEnum::SENDED],
            ['<', 'status', SmsStatusEnum::ERROR],
        ]);
        $query->orderBy(['created_at' => SORT_ASC]);
        /** @var SmsQueueEntity[] $collection */
        $collection = \App::$domain->notify->smsQueue->all($query);
        foreach ($collection as $entity) {
            $isDelivered = \App::$domain->notify->sms->isDelivered($entity->id, $entity->phone);
            if($isDelivered) {
                $entity->status = SmsStatusEnum::DELIVERED;
                $this->update($entity);
            }
        }
    }

    public function updateAllStatus($ids, $status) {
        $query = new Query;
        $query->andWhere(['id' => $ids]);
        /** @var SmsQueueEntity[] $collection */
        $collection = $this->all($query);
        foreach ($collection as $entity) {
            $entity->status = $status;
            $this->update($entity);
        }
    }

    public function updateStatus($id, $status) {
        $this->updateAllStatus([$id], $status);
    }

}
