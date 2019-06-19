<?php


namespace app\widgets;


use app\models\tables\Tasks;
use yii\base\Widget;

class CardWidget extends Widget
{

    public $model;
    public $linked = true;

    public function run()
    {
        if(is_a($this->model,Tasks::class)){
            return $this->render('card', ['model' => $this->model,'linked' => $this->linked]);
        }
        throw new \Exception("Модель должна быть класса таск!");

    }

}