<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Journalmain;

/**
 * JournalmainSearch represents the model behind the search form of `app\models\Journalmain`.
 */
class JournalmainSearch extends Journalmain
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['journal_id', 'business_id', 'business_duration_id'], 'integer'],
            [['reference_no', 'description', 'added_by', 'added_date', 'journal_date'], 'safe'],
            [['tot_journal_amount','tot_journal_cr','tot_journal_dr'], 'number'],
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
        $query = Journalmain::find();

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
            'journal_id' => $this->journal_id,
            'tot_journal_amount' => $this->tot_journal_amount,
            'added_date' => $this->added_date,
            'business_id' => $this->business_id,
            'business_duration_id' => $this->business_duration_id,
            'journal_date' => $this->journal_date,
            'tot_journal_cr' => $this->tot_journal_cr,
            'tot_journal_dr' => $this->tot_journal_dr,
        ]);

        $query->andFilterWhere(['like', 'reference_no', $this->reference_no])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'added_by', $this->added_by]);

        return $dataProvider;
    }
}
