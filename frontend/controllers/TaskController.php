<?php


namespace frontend\controllers;


use app\models\tables\TaskComments;
use frontend\models\filters\CommentsFilter;
use frontend\models\filters\FilesFilter;
use frontend\models\filters\TasksFilter;
use frontend\models\forms\TaskAttachmentsAddForm;
use frontend\models\tables\Chat;
use frontend\models\tables\Comments;
use frontend\models\tables\Files;
use frontend\models\tables\Tasks;
use frontend\models\tables\TaskStatuses;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class TaskController extends Controller
{
    /**
     * {@inheritdoc}
     */
//    public function behaviors()
//    {
//        return [
//
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['card'],
//                'rules' => [
//                    [
//                        'actions' => ['card'],
//                        'allow' => true,
//                        'roles' => ['TaskView'],
//                    ],
//                ],
////                'denyCallback' => function(){
////                    echo 'Доступ запрещен';
////                    exit();
////                },
//            ],
//        ];
//    }


    public function actionIndex()
    {

        $month = Yii::$app->request->post('TasksFilter')['deadline'];
        $searchModel = new TasksFilter();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'month' => $month,
        ]);
    }


    /**
     * Updates an existing Tasks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCard($id)
    {
        $model1 = new Comments();
        if ($model1->load(\Yii::$app->request->post()) && $model1->save()) {
            \Yii::$app->session->setFlash('success', "Комментарий добавлен");
            $model1 = new Comments();
        }


        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->cache->flush();
            //return $this->redirect(['index']);
        }

        $status = TaskStatuses::getStatusesList();
        $responsible = User::getUsersList();


        $searchModelComments = new CommentsFilter();
        $dataProviderComments = $searchModelComments->search(Yii::$app->request->queryParams);

        $searchModelFiles = new FilesFilter();
        $dataProviderFiles = $searchModelFiles->search(Yii::$app->request->queryParams);

        $task_id=Yii::$app->request->get('id');
        $filesnames = Files::find()
            ->where(['task_id' => $task_id])
            ->all();
        if(Yii::$app->request->isPjax){
            $answer = true;
            return $this->render('card', [
                'model' => $model,
                'status'=>$status,
                'responsible'=>$responsible,
                'searchModelComments' => $searchModelComments,
                'dataProviderComments' => $dataProviderComments,
                'searchModelFiles' => $searchModelFiles,
                'dataProviderFiles' => $dataProviderFiles,
                'filesnames' => $filesnames,
                'taskAttachmentForm' => new TaskAttachmentsAddForm(),
                'taskCommentForm' => new Comments(),
                'userId' => \Yii::$app->user->id,
                'id'=>$id,
                'chat'=> new Chat(),
                'answer'=>$answer,
            ]);
        }
        return $this->render('card', [
            'model' => $model,
            'status'=>$status,
            'responsible'=>$responsible,
            'searchModelComments' => $searchModelComments,
            'dataProviderComments' => $dataProviderComments,
            'searchModelFiles' => $searchModelFiles,
            'dataProviderFiles' => $dataProviderFiles,
            'filesnames' => $filesnames,
            'taskAttachmentForm' => new TaskAttachmentsAddForm(),
            'taskCommentForm' => new Comments(),
            'userId' => \Yii::$app->user->id,
            'id'=>$id,
            'chat'=> new Chat(),
        ]);
    }

    /**
     * Finds the Tasks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tasks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tasks::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Creates a new Comments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreatec()
    {
        $model = new Comments();
        $model->task_id=Yii::$app->request->get('id');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/task/card', 'id' => $model->task_id]);
        }

        return $this->render('createcomment', [
            'model' => $model,
        ]);
    }

//    public function actionAddComment()
//    {
//        $model = new Comments();
//        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
//            \Yii::$app->session->setFlash('success', "Комментарий добавлен");
//        } else {
//            \Yii::$app->session->setFlash('error', "Не удалось добавить комментарий");
//        }
//        $this->redirect(\Yii::$app->request->referrer);
//    }

    /**
     * Creates a new Files model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreatef()
    {
        $model = new Files();
        $model->task_id=Yii::$app->request->get('id');

        if ($model->load(Yii::$app->request->post())) {
            $model->task_id=Yii::$app->request->get('id');
            $model->upload = UploadedFile::getInstance($model, 'name');
            $model->name=$model->upload->name;
            $model->save();
            $model->saveFile();
            return $this->redirect(['/task/card', 'id' => $model->task_id]);
        }

        return $this->render('createfile', [
            'model' => $model,
        ]);
    }

    public function actionAddAttachment()
    {
        $model = new TaskAttachmentsAddForm();
        $model->load(\Yii::$app->request->post());
        $model->attachment = UploadedFile::getInstance($model, 'attachment');
        if ($model->save()) {
            \Yii::$app->session->setFlash('success', "Файл добавлен");
        } else {
            \Yii::$app->session->setFlash('error', "Не удалось добавить файл");
        }
        $this->redirect(\Yii::$app->request->referrer);
    }
}