<?php

use app\models\tables\Tasks;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\tables\Tasks */

$this->title = $model->name;
if(!$hide){
    $this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
}

\yii\web\YiiAsset::register($this);
?>
<div class="tasks-view">



    <?php
    echo app\widgets\CardWidget::widget([
        'model'=> $model
    ]);

    ?>

</div>

