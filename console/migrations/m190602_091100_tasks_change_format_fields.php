<?php

use yii\db\Migration;

/**
 * Class m190602_091100_tasks_change_format_fields
 */
class m190602_091100_tasks_change_format_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('tasks','created_at');
        $this->dropColumn('tasks','updated_at');
        $this->addColumn('tasks', 'created_at', 'TIMESTAMP AFTER status_id');
        $this->addColumn('tasks', 'updated_at', 'TIMESTAMP AFTER created_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190602_091100_tasks_change_format_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190602_091100_tasks_change_format_fields cannot be reverted.\n";

        return false;
    }
    */
}
