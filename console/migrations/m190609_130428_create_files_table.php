<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%files}}`.
 */
class m190609_130428_create_files_table extends Migration
{
    protected $tableName = 'files';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer(11),
            'name' => $this->string(50)
        ]);

        $taskTable = 'tasks';
        $this->createIndex("files_task_id_idx", $this->tableName, ['task_id']);
        $this->addForeignKey('fk_task_files',$this->tableName, 'task_id', $taskTable, 'id','CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
