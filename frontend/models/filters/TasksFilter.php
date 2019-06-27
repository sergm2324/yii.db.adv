<?php

namespace app\models\filters;

use app\models\tables\Tasks;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;



/**
 * TasksFilter represents the model behind the search form of `app\models\tables\Tasks`.
 */
class TasksFilter extends Tasks
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'creator_id', 'responsible_id', 'status_id'], 'integer'],
            [['name', 'description', 'deadline'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $month = Yii::$app->request->post('TasksFilter')['deadline'];
        $query = Tasks::find();

        if($month){
            $query->andwhere("MONTH(created_at)= '$month'");
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'pagination'=>[
                'pageSize'=>4
            ],
            'query' => $query,
        ]);

        \Yii::$app->db->cache(function () use ($dataProvider){
            return $dataProvider->prepare();
        });

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'creator_id' => $this->creator_id,
            'responsible_id' => $this->responsible_id,
            'deadline' => $this->deadline,
            'status_id' => $this->status_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at]);


        return $dataProvider;
    }
}
