<?php


namespace console\controllers;


use common\models\tables\TelegramOffset;
use frontend\models\tables\Projects;
use frontend\models\tables\Subscribes;
use SonkoDmitry\Yii\TelegramBot\Component;
use TelegramBot\Api\Types\Message;
use TelegramBot\Api\Types\Update;
use yii\console\Controller;

class TelegramController extends Controller
{
    /** @var  Component */
    private $bot;
    private $offset = 0;

    public function init()
    {
        parent::init();
        $proxy = "212.107.24.61:13579";
        $proxyauth= 'user6277:omp8ka';
        $this->bot = \Yii::$app->bot;
        $this->bot->setCurlOption(CURLOPT_TIMEOUT, 20);
        $this->bot->setCurlOption(CURLOPT_PROXY, "SOCKS5://$proxy");
        $this->bot->setCurlOption(CURLOPT_PROXYUSERPWD, $proxyauth);
        $this->bot->setCurlOption(CURLOPT_CONNECTTIMEOUT, 10);
        $this->bot->setCurlOption(CURLOPT_HTTPHEADER, ['Expect:']);
    }

    public function actionIndex()
    {
        $updates = $this->bot->getUpdates($this->getOffset() + 1);
        $updCount = count($updates);
        if($updCount > 0){
            echo "Новых сообщений " . $updCount . PHP_EOL;
            foreach ($updates as $update){
                $this->updateOffset($update);
                $this->processCommand($update->getMessage());
            }
        }else{
            echo "Новых сообщений нет" . PHP_EOL;
        }
    }

    private function getOffset()
    {
        $max = TelegramOffset::find()
            ->select('id')
            ->max('id');
        if($max > 0){
            $this->offset = $max;
        }
        return $this->offset;
    }

    private function updateOffset(Update $update)
    {
        $model = new TelegramOffset([
            'id' => $update->getUpdateId(),
            'timestamp_offset' => date("Y-m-d H:i:s")
        ]);
        $model->save();
    }

    private function processCommand(Message $message){
        $params = explode(" ",  $message->getText());
        $command = $params[0];
        $response = 'Unknown command';
        $only_subscribe = 0; //флаг отправки сообщений только подписчикам канала
        switch($command){
            case "/help":
                $response = "Доступные команды: \n";
                $response .= "/help - список комманд\n";
                $response .= "/project_create ##project_name## -создание нового проекта\n";
                $response .= "/task_create ##task_name## ##responcible## ##project## -создание таска\n";
                $response .= "/sp_create  - подписка на создание проекта\n";
                break;
            case "/sp_create":
                $model1 = new Subscribes();
                $model1->telegram_id = $message->getFrom()->getId();
                $model1->name = 'new Projects';
                $model1->status_id=1;
                $model1->save();
                $response = "Вы подписаны на оповещения о новых проектах \n";
                break;
            case "/project_create":
                $only_subscribe = 1; //отправляем только подпичикам данного канала
                $model = new Projects();
                $model->name = str_replace('#','',$params[1]);
                $model->save();
                $subscribes = Subscribes::find()->where(['name' => 'new Projects'])->all();
                $response = "Проект {$model->name} успешно создан \n";
                break;
        }

        if($only_subscribe===0){
            $this->bot->sendMessage($message->getFrom()->getId(), $response);
        } else {
            foreach ($subscribes as $value){
                if ($value['status_id']===1){
                    $this->bot->sendMessage($value['telegram_id'], $response);
                }
        }
        }
    }
}