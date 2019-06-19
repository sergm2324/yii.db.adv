<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 */
class m190609_130509_create_comments_table extends Migration
{
    protected $tableName = 'comments';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer(11),
            'name' => $this->string(250)
        ]);

        $taskTable = 'tasks';
        $this->createIndex("comments_task_id_idx", $this->tableName, ['task_id']);
        $this->addForeignKey('fk_task_comments',$this->tableName, 'task_id', $taskTable, 'id','CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
