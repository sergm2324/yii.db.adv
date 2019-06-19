<?php

namespace app\models\filters;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\tables\Files;

/**
 * FilesFilter represents the model behind the search form of `app\models\tables\Files`.
 */
class FilesFilter extends Files
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'task_id'], 'integer'],
            [['name'], 'safe'],
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
        $id=Yii::$app->request->get('id');
        $query = Files::find()->andwhere("task_id='$id'");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'pagination'=>[
                'pageSize'=>3
            ],
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'task_id' => $this->task_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
