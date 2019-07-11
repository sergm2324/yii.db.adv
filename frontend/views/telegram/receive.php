<?php
$srcipt = <<<JS
    setInterval(function(){   
$("#btn-refresh").click();
}, 5000);
JS;

$this->registerJs($srcipt);
\yii\widgets\Pjax::begin();?>
<div class="message-container">
    <?php
    echo \yii\helpers\Html::a("Refresh", ["telegram/receive"], ['id' => 'btn-refresh', 'class' => 'btn btn-success']);
    foreach ($messages as $message):?>
        <div>
            <strong><?=$message['username']?>: </strong>
            <?=$message['text']?>:
            <?=$message['userid']?>
        </div>
    <?php endforeach;?>
</div>
<?php \yii\widgets\Pjax::end()?>