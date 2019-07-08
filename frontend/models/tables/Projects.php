<?php

namespace frontend\models\tables;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "projects".
 *
 * @property int $id
 * @property string $name Название проекта
 * @property Tasks[] $tasks
 */
class Projects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'projects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['id_project' => 'id']);
    }

    public static function getProjectsList(){
        $projects = static::find()
            ->select(['id','name'])
            ->asArray()
            ->all();
        $projectAr = ArrayHelper::map($projects, 'id','name');
        return $projectAr;
    }
}
