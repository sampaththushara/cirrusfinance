<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AccEntryDetail;

/**
 * AccEntryDetailSearch represents the model behind the search form of `app\models\AccEntryDetail`.
 */
class AccEntryDetailSearch extends AccEntryDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entry_detail_id', 'char_of_acc_id', 'entry_id'], 'integer'],
            [['entry_amount'], 'number'],
            [['dr_cr', 'reconcilation_date'], 'safe'],
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
        $query = AccEntryDetail::find();

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
            'entry_detail_id' => $this->entry_detail_id,
            'char_of_acc_id' => $this->char_of_acc_id,
            'entry_amount' => $this->entry_amount,
            'reconcilation_date' => $this->reconcilation_date,
            'entry_id' => $this->entry_id,
        ]);

        $query->andFilterWhere(['like', 'dr_cr', $this->dr_cr]);

        return $dataProvider;
    }
}
