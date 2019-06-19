<?php

namespace yii2lab\notify\domain\entities;

use yii\behaviors\TimestampBehavior;
use yii2lab\notify\domain\enums\SmsStatusEnum;
use yii2rails\domain\BaseEntity;
use yii2rails\domain\behaviors\entity\TimeValueFilter;

/**
 * Class SmsQueueEntity
 * 
 * @package yii2lab\notify\domain\entities
 * 
 * @property $id
 * @property $phone
 * @property $content
 * @property $status
 * @property $updated_at
 * @property $created_at
 */
class SmsQueueEntity extends BaseEntity {

	protected $id;
	protected $phone;
	protected $content;
	protected $status = SmsStatusEnum::NEW;
	protected $updated_at;
	protected $created_at;

    public function behaviors()
    {
        return [
            [
                'class' => TimeValueFilter::class,
            ],
        ];
    }

    public function rules()
    {
        return [
            [['phone','content', 'status'], 'required'],
            ['status', 'in', 'range' => SmsStatusEnum::values()],
        ];
    }
}
