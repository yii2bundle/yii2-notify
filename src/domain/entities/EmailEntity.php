<?php

namespace yii2lab\notify\domain\entities;

use yii2rails\domain\BaseEntity;
use yii2rails\domain\values\LangValue;

/**
 * Class EmailEntity
 *
 * @package yii2lab\notify\domain\entities
 *
 * @property string $from
 * @property string $address
 * @property string $subject
 * @property string $content
 * @property AttachmentEntity[] $attachments
 */
class EmailEntity extends BaseEntity {

    protected $from;
	protected $address;
	protected $subject;
	protected $content;
	protected $attachments;
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['content', 'subject'], 'trim'],
			[['address', 'content', 'from'], 'required'],
			['address', 'from', 'email'],
		];
	}
	
	public function fieldType() {
		return [
			'subject' => LangValue::class,
			'content' => LangValue::class,
			'attachments' => [
				'type' => AttachmentEntity::class,
				'isCollection' => true,
			],
		];
	}
	
}
