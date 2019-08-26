<?php

namespace yii2lab\notify\domain\entities;

use yii2rails\domain\BaseEntity;
use yii2rails\domain\values\LangValue;

/**
 * Class SmsEntity
 *
 * @package yii2lab\notify\domain\entities
 *
 * @property $id
 * @property string $address
 * @property string $content
 * @property integer $format
 */
class SmsEntity extends BaseEntity {

    protected $id;
	protected $address;
	protected $content;
	protected $format;
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['content'], 'trim'],
			[['address', 'content'], 'required'],
            [['id', 'format'], 'integer'],
		];
	}
	
	public function fieldType() {
		return [
            'id' => 'integer',
			'content' => LangValue::class,
		];
	}
	
}
