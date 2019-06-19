<?php

use yii\db\Migration;

/**
 * Class m190602_084529_tasks_add_created_updated
 */
class m190602_084529_tasks_add_created_updated extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tasks', 'created_at', 'DATETIME AFTER status_id');
        $this->addColumn('tasks', 'updated_at', 'DATETIME AFTER created_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('tasks','created_at');
        $this->dropColumn('tasks','updated_at');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190602_084529_tasks_add_created_updated cannot be reverted.\n";

        return false;
    }
    */
}
