<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ExpenseMaster;

/**
 * ExpenseMasterSearch represents the model behind the search form of `app\models\ExpenseMaster`.
 */
class ExpenseMasterSearch extends ExpenseMaster
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['exp_id', 'expense_status'], 'integer'],
            [['expense_category'], 'safe'],
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
        $query = ExpenseMaster::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
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
            'exp_id' => $this->exp_id,
            'expense_status' => $this->expense_status,
        ]);

        $query->andFilterWhere(['like', 'expense_category', $this->expense_category]);

        return $dataProvider;
    }
}
