<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks_statuses}}`.
 */
class m190526_122517_create_tasks_statuses_table extends Migration
{
    protected $tableName = 'task_statuses';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)
        ]);

        $this->batchInsert($this->tableName, ['name'], [
            ['Новая'],
            ['В работе'],
            ['Выполнена'],
            ['Тестирование'],
            ['Доработка'],
            ['Закрыта'],
        ]);

        $taskTable = 'tasks';

        //$this->addColumn($taskTable,'status', $this->integer());

        $this->addForeignKey('fk_task_statuses',$taskTable, 'status_id', $this->tableName, 'id');
        $this->update($taskTable, ['status_id' => 1]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
