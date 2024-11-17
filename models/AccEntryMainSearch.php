<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AccEntryMain;

/**
 * AccEntryMainSearch represents the model behind the search form of `app\models\AccEntryMain`.
 */
class AccEntryMainSearch extends AccEntryMain
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entry_id', 'business_id'], 'integer'],
            [['ref_no', 'entry_date', 'narration', 'entry_type'], 'safe'],
            [['dr_total', 'cr_total'], 'number'],
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
        $query = AccEntryMain::find();

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
            'entry_id' => $this->entry_id,
            'entry_date' => $this->entry_date,
            'dr_total' => $this->dr_total,
            'cr_total' => $this->cr_total,
            'business_id' => $this->business_id,
        ]);

        $query->andFilterWhere(['like', 'ref_no', $this->ref_no])
            ->andFilterWhere(['like', 'narration', $this->narration])
            ->andFilterWhere(['like', 'entry_type', $this->entry_type]);

        return $dataProvider;
    }
}
