<?php

use yii2lab\db\domain\db\MigrationCreateTable as Migration;
use yii2lab\notify\domain\enums\SmsStatusEnum;

/**
 * Class m190619_153328_create_notify_sms_queue_table
 * 
 * @package 
 */
class m190619_153328_create_notify_sms_queue_table extends Migration {

	public $table = 'notify_sms_queue';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
            'id' => $this->primaryKey(),
			'phone' => $this->string()->notNull(),
			'content' => $this->string()->notNull(),
			'status' => $this->integer()->notNull()->defaultValue(SmsStatusEnum::NEW),
			'updated_at' => $this->timestamp(),
			'created_at' => $this->timestamp()->notNull(),
		];
	}

	public function afterCreate()
	{
		
	}

}