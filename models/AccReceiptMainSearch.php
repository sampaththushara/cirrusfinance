<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AccReceiptMain;

/**
 * AccReceiptMainSearch represents the model behind the search form of `app\models\AccReceiptMain`.
 */
class AccReceiptMainSearch extends AccReceiptMain
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rpt_id', 'account_id', 'business_id'], 'integer'],
            [['reference_no', 'payer_name', 'description', 'added_by', 'added_date', 'receipt_date'], 'safe'],
            [['tot_receipt_amount'], 'number'],
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
        $query = AccReceiptMain::find();

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
            'rpt_id' => $this->rpt_id,
            'account_id' => $this->account_id,
            'tot_receipt_amount' => $this->tot_receipt_amount,
            'added_date' => $this->added_date,
            'business_id' => $this->business_id,
            'receipt_date' => $this->receipt_date,
        ]);

        $query->andFilterWhere(['like', 'reference_no', $this->reference_no])
            ->andFilterWhere(['like', 'payer_name', $this->payer_name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'added_by', $this->added_by])
            ->andFilterWhere(['like', 'receipt_date', $this->receipt_date]);

        return $dataProvider;
    }
}
