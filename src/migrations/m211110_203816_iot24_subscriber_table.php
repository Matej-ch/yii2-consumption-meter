<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%iot24_subscriber}}`.
 */
class m211110_203816_iot24_subscriber_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%iot24_subscriber}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string(512),
            'devices' => $this->text(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),

        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%iot24_subscriber}}');
    }
}