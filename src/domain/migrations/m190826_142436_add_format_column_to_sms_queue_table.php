<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `notify.sms_queue`.
 */
class m190826_142436_add_format_column_to_sms_queue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('notify_sms_queue', 'format', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('notify_sms_queue', 'format');
    }
}
