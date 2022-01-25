<?php

use yii\db\Migration;

class m211110_203817_add_aliases_column_to_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('iot24', 'aliases', $this->text());
    }

    public function safeDown()
    {
        $this->dropColumn('iot24', 'aliases');
    }
}