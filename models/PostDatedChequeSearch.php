<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PostDatedCheque;

/**
 * PostDatedChequeSearch represents the model behind the search form of `app\models\PostDatedCheque`.
 */
class PostDatedChequeSearch extends PostDatedCheque
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'account_id'], 'integer'],
            [['cheque_no', 'cheque_date', 'received_date', 'customer_name', 'chq_description', 'chq_status', 'chq_amount', 'paid_chq_amount'], 'safe'],
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
        $query = PostDatedCheque::find();

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
            'id' => $this->id,
            'account_id' => $this->account_id,
            'cheque_date' => $this->cheque_date,
            'received_date' => $this->received_date,
        ]);

        $query->andFilterWhere(['like', 'cheque_no', $this->cheque_no])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'chq_description', $this->chq_description])
            ->andFilterWhere(['like', 'chq_status', $this->chq_status])
            ->andFilterWhere(['like', 'chq_amount', $this->chq_amount]);

        return $dataProvider;
    }
}
