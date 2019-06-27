<?php


namespace app\models\forms;


use app\models\tables\Files;
use yii\base\Model;
use yii\imagine\Image;
use yii\web\UploadedFile;

class TaskAttachmentsAddForm extends Model
{
    public $taskId;
    /** @var  UploadedFile */
    public $attachment;


    protected $originalDir = '@img/';
    protected $copiesDir = '@img/small/';

    protected $filepath;
    protected $filename;

    public function rules()
    {
        return [
            [['taskId', 'attachment'], 'required'],
            [['taskId'], 'integer'],
            [['attachment'], 'file', 'extensions' => 'jpg, png']
        ];
    }

    public function save()
    {
        if($this->validate()){
            $this->saveUploadedFile();
            $this->createMinCopy();
            return $this->saveData();
        }
        return false;
    }

    private function saveUploadedFile(){
        $randomString = \Yii::$app->security->generateRandomString();
        $this->filename = $randomString . "." . $this->attachment->getExtension();
        $this->filepath = \Yii::getAlias("{$this->originalDir}{$this->filename}");
        $this->attachment->saveAs($this->filepath);
    }

    private function createMinCopy(){
        Image::thumbnail($this->filepath, 100, 100)
            ->save(\Yii::getAlias("{$this->copiesDir}{$this->filename}"));
    }

    private function saveData(){
        $model = new Files([
            'task_id' => $this->taskId,
            'name' => $this->filename
        ]);
        return $model->save();
    }
}