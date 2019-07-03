<?php

namespace frontend\models\tables;

//use app\components\Bootstrap;
use frontend\models\tables\Comments;
use common\models\User;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $name Название задачи
 * @property string $description
 * @property int $creator_id
 * @property int $responsible_id
 * @property string $deadline
 * @property int $status_id
 * @property int $created_at
 * @property int $updated_at
 * @property $status
 *
 * @property $usercr
 *
 * @property $userres
 */
class Tasks extends \yii\db\ActiveRecord
{
    public function behaviors(){

        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],

        ];
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['creator_id', 'responsible_id', 'status_id'], 'integer'],
            [['deadline'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => \Yii::t('app','Name'),
            'description' => \Yii::t('app','Description'),
            'creator_id' => \Yii::t('app','Creator ID'),
            'responsible_id' => \Yii::t('app','Responsible ID'),
            'deadline' => \Yii::t('app','Deadline'),
            'status_id' => \Yii::t('app','Status ID'),
        ];
    }

    public function getStatus()
    {
        return $this->hasOne(TaskStatuses::class, ['id' => 'status_id']);
    }

    public function getUsercr()
    {
        return $this->hasOne( User::class, ['id' => 'creator_id']);
    }

    public function getUserres()
    {
        return $this->hasOne(User::class, ['id' => 'responsible_id']);
    }

    public function getTaskComments()
    {
        return $this->hasMany(Comments::class, ['task_id' => 'id']);
    }


    public function getTasksAll()
    {
        $db = \Yii::$app->db;
        $tasks = $db->createCommand("SELECT * FROM tasks")
            ->queryAll();
        return $tasks;
    }

}
