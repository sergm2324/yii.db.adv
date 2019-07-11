<?php


namespace frontend\controllers;


use frontend\models\tables\Subscribes;
use SonkoDmitry\Yii\TelegramBot\Component;
use yii\web\Controller;

class TelegramController extends Controller
{
    public function actionReceive()
    {
        $proxy = "212.107.24.61:13579";
        $proxyauth= 'user6277:omp8ka';

        /** @var Component $bot */
        $bot = \Yii::$app->bot;
        $bot->setCurlOption(CURLOPT_TIMEOUT, 20);
        $bot->setCurlOption(CURLOPT_PROXY, "SOCKS5://$proxy");
        $bot->setCurlOption(CURLOPT_PROXYUSERPWD, $proxyauth);
        $bot->setCurlOption(CURLOPT_CONNECTTIMEOUT, 10);
        $bot->setCurlOption(CURLOPT_HTTPHEADER, ['Expect:']);

        $updates = $bot->getUpdates();

        $messages = [];
        foreach ($updates as $update){
            $user_id = $update -> getMessage ()-> getFrom ()-> getID ();
            $message = $update->getMessage();
            $username = $message->getFrom()->getFirstName() . " "
                . $message->getFrom()->getLastName();
            $messages[] = [
                'text' => $message->getText(),
                'username' => $username,
                'userid' => $user_id,
            ];
        }
        return $this->render('receive', ['messages' => $messages]);
    }

    public function actionSend()
    {
        $proxy = "212.107.24.61:13579";
        $proxyauth= 'user6277:omp8ka';

        /** @var Component $bot */
        $bot = \Yii::$app->bot;
        $bot->setCurlOption(CURLOPT_TIMEOUT, 20);
        $bot->setCurlOption(CURLOPT_PROXY, "SOCKS5://$proxy");
        $bot->setCurlOption(CURLOPT_PROXYUSERPWD, $proxyauth);
        $bot->setCurlOption(CURLOPT_CONNECTTIMEOUT, 10);
        $bot->setCurlOption(CURLOPT_HTTPHEADER, ['Expect:']);

        $bot->sendMessage(423078099, 'From yii with love');
    }

    public function actionSubscribe(){
        $subscribes = Subscribes::find()->where(['name' => 'new Projects'])->all();
        foreach ($subscribes as $value){
            var_dump($value['telegram_id']);

        }

    }
}