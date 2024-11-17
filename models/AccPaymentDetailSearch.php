<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AccPaymentDetail;

/**
 * AccPaymentDetailSearch represents the model behind the search form of `app\models\AccPaymentDetail`.
 */
class AccPaymentDetailSearch extends AccPaymentDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pmt_detail_id', 'chart_of_acc_id', 'pmt_main_id'], 'integer'],
            [['pmt_detail_desc'], 'safe'],
            [['quantity', 'unit_price', 'line_total'], 'number'],
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
        $query = AccPaymentDetail::find();

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
            'pmt_detail_id' => $this->pmt_detail_id,
            'chart_of_acc_id' => $this->chart_of_acc_id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'line_total' => $this->line_total,
            'pmt_main_id' => $this->pmt_main_id,
        ]);

        $query->andFilterWhere(['like', 'pmt_detail_desc', $this->pmt_detail_desc]);

        return $dataProvider;
    }
}
