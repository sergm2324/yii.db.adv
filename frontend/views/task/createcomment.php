<?php

use app\models\tables\Comments;
use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\tables\Comments */

$this->title = Yii::t('app', 'Create Comments');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formcomment', [
        'model' => $model,
    ]) ?>

</div>