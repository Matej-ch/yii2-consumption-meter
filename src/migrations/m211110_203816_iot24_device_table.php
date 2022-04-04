<?php

use yii\db\Migration;


/**
 * Handles the creation of table `{{%iot24_device}}`.
 */
class m211110_203816_iot24_device_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%iot24_device}}', [
            'id' => $this->primaryKey(),
            'endpoint' => $this->string(1024),
            'device_id' => $this->string(1024),
            'device_name' => $this->string(512),
            'device_type_id' => $this->integer(),
            'device_type_name' => $this->string(512),
            'refresh_interval_minutes' => $this->string(16),
            'pulse_frequency' => $this->text(),
            'aliases' => $this->text(),
            'is_active' => $this->integer()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),

        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%iot24_device}}');
    }
}