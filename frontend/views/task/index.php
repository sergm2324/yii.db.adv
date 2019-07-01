<?php

use frontend\models\filters\TasksFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\web\View;
use yii\bootstrap\ActiveForm;

\Yii::$app->language =$_SESSION['language'];


/* @var $this yii\web\View */
/* @var $searchModel frontend\models\filters\TasksFilter */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список задач';
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin([
    'id' => 'selectMonth-form',
    'options' => ['class' => 'form-horizontal'],
]);
$items = [
    '1' => 'Январь',
    '2'=>'Февраль',
    '3'=>'Март',
    '4'=>'Апрель',
    '5'=>'Май',
    '6'=>'Июнь',
    '7'=>'Июль',
    '8'=>'Август',
    '9'=>'Сентябрь',
    '10'=>'Октябрь',
    '11'=>'Ноябрь',
    '12'=>'Декабрь'
];
$params = [
    'prompt' => 'Выберите месяц..',
];

echo $form->field($searchModel, 'deadline')->dropDownList($items,$params); ?>
<div class="form-group">
    <span class="col-lg-offset-1 col-lg-11">Вы выбрали месяц: <?= $month?></span>
    <div class="col-lg-offset-1 col-lg-11">
        <?= Html::submitButton('Отфильтровать', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end();?>

<div class="tasks-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    echo yii\widgets\ListView::widget([
        'itemView'=>'myview',
        'dataProvider'=>$dataProvider,
        'viewParams'=>[
            'hide'=>'true'
        ],
        'options' => [
            'tag' => 'div',
            'class' => 'preview-container',
            'id' => 'news-list',
        ],
        'layout' => "\n{items}",

    ]);

    echo frontend\widgets\MyPaginatorWidget::widget([
        'dataProvider'=>$dataProvider,
        'layout' => "\n{pager}",
    ]);

    ?>




</div>