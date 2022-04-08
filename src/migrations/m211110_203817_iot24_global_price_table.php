<?php

namespace matejch\iot24meter\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%iot24_global_price}}`.
 */
class m211110_203817_iot24_global_price_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%iot24_global_price}}', [
            'id' => $this->primaryKey(),
            'price' => $this->decimal(10, 4),
            'year' => $this->integer(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),

        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%iot24_subscriber}}');
    }
}