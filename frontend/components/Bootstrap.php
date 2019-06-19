<?php


namespace app\components;

use app\models\tables\Tasks;
use common\models\User;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\Event;
use Yii;
use yii\helpers\Url;

class Bootstrap extends Component implements BootstrapInterface
{

        public function bootstrap($app)
        {
            $this->setLang();
            $this->attachEventsHandler();

        }

        private function attachEventsHandler()
        {
            Event::on(Tasks::class, Tasks::EVENT_AFTER_INSERT,
                function ($event) {
                    $user = User::findOne([
                        'id'=>$event->sender['responsible_id']
                    ]);
                    Yii::$app->mailer->compose()
                        ->setTo($user->email)
                        ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                        ->setReplyTo(['adminka@mail.ru'])
                        ->setSubject('New task')
                        ->setTextBody('You have the new task!')
                        ->send();
                });
        }

        private function setLang()
        {

            if($lang = Yii::$app->session->get('language'))
            {
                \Yii::$app->language = $lang;
            }
        }

}