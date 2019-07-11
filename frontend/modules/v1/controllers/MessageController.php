<?php


namespace frontend\modules\v1\controllers;


use common\models\User;
use frontend\models\tables\Projects;
use frontend\models\tables\Subscribes;
use frontend\models\tables\Tasks;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class MessageController extends ActiveController
{
    public $modelClass = Tasks::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authentificator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => function($username, $password){
                $user = User::findByUsername($username);
                if($user !== null && $user->validatePassword($password)){
                    return $user;
                }
                return null;
            }
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions =  parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex(){
        //пример запроса - http://front.site.local/v1/messages?responsible_id=2

        if ($request=\Yii::$app->request->get('responsible_id')){
            $query = Tasks::find()->where(['responsible_id' => $request]);
        } else {
            $query = Tasks::find();
        }

        return new ActiveDataProvider([
           'query' => $query,
        ]);

    }

}