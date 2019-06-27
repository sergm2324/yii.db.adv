<?php

use yii\db\Migration;

/**
 * Class m190602_090851_task_statuses_add_fields2
 */
class m190602_090851_task_statuses_add_fields2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('task_statuses', 'created_at', 'TIMESTAMP AFTER name');
        $this->addColumn('task_statuses', 'updated_at', 'TIMESTAMP AFTER created_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190602_090851_task_statuses_add_fields2 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190602_090851_task_statuses_add_fields2 cannot be reverted.\n";

        return false;
    }
    */
}
