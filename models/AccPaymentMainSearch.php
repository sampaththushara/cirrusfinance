<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AccPaymentMain;

/**
 * AccPaymentMainSearch represents the model behind the search form of `app\models\AccPaymentMain`.
 */
class AccPaymentMainSearch extends AccPaymentMain
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pmt_id', 'account_id', 'business_duration_id'], 'integer'],
            [['reference_no', 'po_reference', 'payee_name', 'description', 'added_by', 'added_date', 'payment_date'], 'safe'],
            [['tot_payment_amount'], 'number'],
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
        $query = AccPaymentMain::find();

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
            'pmt_id' => $this->pmt_id,
            'account_id' => $this->account_id,
            'tot_payment_amount' => $this->tot_payment_amount,
            'added_date' => $this->added_date,
            'business_duration_id' => $this->business_duration_id,
            'payment_date' => $this->payment_date,
        ]);

        $query->andFilterWhere(['like', 'reference_no', $this->reference_no])
            ->andFilterWhere(['like', 'po_reference', $this->po_reference])
            ->andFilterWhere(['like', 'payee_name', $this->payee_name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'added_by', $this->added_by]);

        return $dataProvider;
    }
}
