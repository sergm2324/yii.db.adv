<?php

namespace app\models\tables;

use Yii;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property int $task_id
 * @property string $name
 *
 * @property Tasks $task
 */
class Files extends \yii\db\ActiveRecord
{

    /** @var UploadedFile  */
    public $upload;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
            ['upload','file','extensions' =>'jpg,png'],
        ];
    }

    public function saveFile()
    {
        if($this->validate('upload')){
            $filepath = \Yii::getAlias("@webroot/img/{$this->upload->name}");
            $this->upload->saveAs($filepath);
            Image::thumbnail($filepath, 100,100)
                ->save(\Yii::getAlias("@webroot/img/small/{$this->upload->name}"));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'task_id' => Yii::t('app', 'Task ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }
}
