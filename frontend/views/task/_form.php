<?php

use frontend\models\filters\CommentsFilter;
use frontend\models\filters\FilesFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model frontend\models\tables\Tasks */
/* @var $form yii\widgets\ActiveForm */

/* @var $searchModelComments frontend\models\filters\CommentsFilter */
/* @var $dataProviderComments yii\data\ActiveDataProvider */
/* @var $searchModelFiles frontend\models\filters\FilesFilter */
/* @var $dataProviderFiles yii\data\ActiveDataProvider */
\frontend\assets\TaskAsset::register($this);

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

<?//php if(Yii::$app->user->can('TaskDelete')):?>
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

    <h3>Комментарии</h3>
    <?php $form = ActiveForm::begin(['action' => Url::to(['task/add-comment'])]);?>
    <?=$form->field($taskCommentForm, 'user_id')->hiddenInput(['value' => $userId])->label(false);?>
    <?=$form->field($taskCommentForm, 'task_id')->hiddenInput(['value' => $model->id])->label(false);?>
    <?=$form->field($taskCommentForm, 'name')->textInput();?>
    <?=Html::submitButton("Добавить",['class' => 'btn btn-default']);?>
    <?ActiveForm::end()?>
    <hr>
    <div class="comment-history">
        <?foreach ($model->taskComments as $comment): ?>
            <p><strong><?=$comment->user->username?></strong>: <?=$comment->name?></p>
        <?php endforeach;?>
    </div>

    <h1>Chat</h1>
    <form action="#" name="chat_form" id="chat_form">
        <label>
            введите сообщение
            <input type="text" name="message"/>
            <input type="submit"/>
        </label>
    </form>
    <hr>
    <div id="username" class="hidden"><?php echo \common\models\User::findOne(Yii::$app->user->id)->username ?></div>
    <div id="user_id" class="hidden"><?php echo \common\models\User::findOne(Yii::$app->user->id)->id ?></div>
    <div id="task_id" class="hidden"><?php echo $model->id ?></div>
    <div id="chat"></div>

</div>
<?//php endif;?>






