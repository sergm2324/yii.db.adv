<?php

use app\models\tables\Files;
use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\tables\Files */

$this->title = Yii::t('app', 'Create Files');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Files'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="files-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formfile', [
        'model' => $model,
    ]) ?>

</div>
