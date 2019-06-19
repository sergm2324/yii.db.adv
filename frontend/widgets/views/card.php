<?php
use yii\helpers\Url;

/** @var $model app\models\tables\Tasks */
?>

<div class="task-container">
    <?php if ($linked): ?>
    <a class="task-preview-link" href="<?= Url::to(['task/card', 'id' => $model['id']]) ?>">
        <? endif; ?>
        <div class="task-preview">
            <div class="task-preview-header"><?= $model->name ?></div>
            <div class="task-preview-content"><?=$model['description']?></div>
            <div class="task-preview-user"><?=$model->usercr->username?></div>
            <div class="task-preview-user"><?=$model->userres->username?></div>
            <div class="task-preview-user"><?=$model['deadline']?></div>
            <div class="task-preview-user"><?=$model->status->name?></div>
        </div>
        <?php if ($linked): ?>
    </a>
<? endif; ?>
</div>




