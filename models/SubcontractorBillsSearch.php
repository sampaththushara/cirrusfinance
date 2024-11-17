<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SubcontractorBills;

/**
 * SubcontractorBillsSearch represents the model behind the search form of `app\models\SubcontractorBills`.
 */
class SubcontractorBillsSearch extends SubcontractorBills
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bill_id', 'page_id', 'business_id'], 'integer'],
            [['payee_name', 'bill_date', 'received_date', 'bill_status'], 'safe'],
            [['bill_amount'], 'number'],
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
        $query = SubcontractorBills::find();

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
            'bill_id' => $this->bill_id,
            'page_id' => $this->page_id,
            'bill_amount' => $this->bill_amount,
            'bill_date' => $this->bill_date,
            'business_id' => $this->business_id,
            'received_date' => $this->received_date,
        ]);

        $query->andFilterWhere(['like', 'payee_name', $this->payee_name])
            ->andFilterWhere(['like', 'bill_status', $this->bill_status]);

        return $dataProvider;
    }
}
