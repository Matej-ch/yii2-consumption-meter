<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%iot24_price_map}}`.
 */
class m211110_203816_iot24_price_map_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%iot24_price_map}}', [
            'id' => $this->primaryKey(),
            'device_id' => $this->string(512),
            'channel' => $this->string(256),
            'from' => $this->string(256),
            'to' => $this->string(256),
            'price' => $this->integer(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),

        ],$tableOptions);

        $this->createIndex('{{%idx-iot-device_id}}', '{{%iot24_price_map}}', 'device_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('{{%idx-iot-device_id}}', '{{%iot24_price_map}}');

        $this->dropTable('{{%iot24_price_map}}');
    }
}