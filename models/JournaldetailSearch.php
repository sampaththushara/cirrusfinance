<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Journaldetail;

/**
 * JournaldetailSearch represents the model behind the search form of `app\models\Journaldetail`.
 */
class JournaldetailSearch extends Journaldetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['journal_detail_id', 'chart_of_acc_id', 'journal_main_id'], 'integer'],
            [['journal_detail_desc'], 'safe'],
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
        $query = Journaldetail::find();

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
            'journal_detail_id' => $this->journal_detail_id,
            'chart_of_acc_id' => $this->chart_of_acc_id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'line_total' => $this->line_total,
            'journal_main_id' => $this->journal_main_id,
        ]);

        $query->andFilterWhere(['like', 'journal_detail_desc', $this->journal_detail_desc]);

        return $dataProvider;
    }
}
