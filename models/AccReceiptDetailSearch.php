<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AccReceiptDetail;

/**
 * AccReceiptDetailSearch represents the model behind the search form of `app\models\AccReceiptDetail`.
 */
class AccReceiptDetailSearch extends AccReceiptDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rpt_detail_id', 'chart_of_acc_id', 'rpt_main_id'], 'integer'],
            [['rpt_detail_desc'], 'safe'],
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
        $query = AccReceiptDetail::find();

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
            'rpt_detail_id' => $this->rpt_detail_id,
            'chart_of_acc_id' => $this->chart_of_acc_id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'line_total' => $this->line_total,
            'rpt_main_id' => $this->rpt_main_id,
        ]);

        $query->andFilterWhere(['like', 'rpt_detail_desc', $this->rpt_detail_desc]);

        return $dataProvider;
    }
}
