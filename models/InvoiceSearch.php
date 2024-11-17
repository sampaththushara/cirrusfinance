<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Invoice;

/**
 * InvoiceSearch represents the model behind the search form of `app\models\Invoice`.
 */
class InvoiceSearch extends Invoice
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invoice_id', 'business_id', 'bill_id'], 'integer'],
            [['invoice_date', 'invoice_created_by', 'created_date'], 'safe'],
            [['VAT', 'NBT', 'tot_invoice_amount', 'receipt_balance'], 'number'],
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
        $query = Invoice::find();

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
            'invoice_id' => $this->invoice_id,
            'invoice_date' => $this->invoice_date,
            'VAT' => $this->VAT,
            'NBT' => $this->NBT,
            'tot_invoice_amount' => $this->tot_invoice_amount,
            'receipt_balance' => $this->receipt_balance,
            'business_id' => $this->business_id,
            'bill_id' => $this->bill_id,
            'created_date' => $this->created_date,
        ]);

        $query->andFilterWhere(['like', 'invoice_created_by', $this->invoice_created_by]);

        return $dataProvider;
    }
}
