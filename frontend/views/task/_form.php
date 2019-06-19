<?php

use app\models\filters\CommentsFilter;
use app\models\filters\FilesFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\tables\Tasks */
/* @var $form yii\widgets\ActiveForm */

/* @var $searchModelComments app\models\filters\CommentsFilter */
/* @var $dataProviderComments yii\data\ActiveDataProvider */
/* @var $searchModelFiles app\models\filters\FilesFilter */
/* @var $dataProviderFiles yii\data\ActiveDataProvider */
\app\assets\TaskAsset::register($this);

$this->title = Yii::t('app', 'Comments');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="task-edit">
    <div class="task-main">
        <?php $form = ActiveForm::begin(['action' => Url::to(['task/card', 'id' => $model->id])]);?>
        <?=$form->field($model, 'name')->textInput();?>
        <div class="row">
            <div class="col-lg-4">
                <?=$form->field($model, 'status_id')->dropDownList($status)?>
            </div>
            <div class="col-lg-4">
                <?=$form->field($model, 'responsible_id')->dropDownList($responsible)?>
            </div>
            <div class="col-lg-4">
                <?=$form->field($model, 'deadline')
//                ->widget(\yii\jui\DatePicker::class, [
//                    'language' => 'ru',
//                    'dateFormat' => 'yyyy-MM-dd'
//                ])
                    ->textInput(['type' => 'date'])
                ?>
            </div>
        </div>

        <div>
            <?=$form->field($model, 'description')
                ->textarea()?>
        </div>
        <?=Html::submitButton(\Yii::t("app",'Save'),['class' => 'btn btn-success']);?>
        <?ActiveForm::end()?>
        <br>
        <button class = "push-me btn btn-success">Нажми меня</button>
    </div>
</div>

<?php if(Yii::$app->user->can('TaskDelete')):?>
<div class="attachments">
    <h3>Вложения</h3>
    <?php $form = ActiveForm::begin([
        'action' => Url::to(['task/add-attachment']),
        'options' => ['class' => "form-inline"]
    ]);?>
    <?=$form->field($taskAttachmentForm, 'taskId')->hiddenInput(['value' => $model->id])->label(false);?>
    <?=$form->field($taskAttachmentForm, 'attachment')->fileInput();?>
    <?=Html::submitButton("Добавить",['class' => 'btn btn-default']);?>
    <?ActiveForm::end()?>
    <hr>

    <div class="attachments-history">
        <?foreach ($filesnames as $value): ?>
            <a href="/img/<?=$value['name']?>">
                <img src="/img/small/<?=$value['name']?>" alt="">
            </a>
        <?php endforeach;?>
    </div>

</div>
<?php endif;?>

<hr>

        <p>
            <?= Html::a(Yii::t('app', 'Create Comments'), ['createc','id' => $model->id], ['class' => 'btn btn-success']) ?>
        </p>
        <?= GridView::widget([
            'dataProvider' => $dataProviderComments,
            'filterModel' => $searchModelComments,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'name',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>



