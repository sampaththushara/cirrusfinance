<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblReceivable;
use app\models\AccBusiness;

/**
 * TblReceivableSearch represents the model behind the search form of `app\models\TblReceivable`.
 */
class TblReceivableSearch extends TblReceivable
{
    /**
     * {@inheritdoc}
     */

    public $project_name;
    public $payer_name;

    public function rules()
    {
        return [
            [['receivable_id', 'project_id', 'payer_id'], 'integer'],
            [['project_name', 'payer_name', 'due_date', 'receivable_description', 'receivable_category', 'period_from', 'period_to', 'added_date', 'added_by', 'receivable_status', 'receivable_amount'], 'safe'],
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
        $query = TblReceivable::find();

        // add conditions that should always apply here
        $query->joinWith(['project', 'payer']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['project_name'] = [
            'asc' => ['acc_business.business_name' => SORT_ASC],
            'desc' => ['acc_business.business_name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['payer_name'] = [
            'asc' => ['payer_master.payer_name' => SORT_ASC],
            'desc' => ['payer_master.payer_name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'receivable_id' => $this->receivable_id,
            'due_date' => $this->due_date,
            'receivable_amount' => $this->receivable_amount,
            'period_from' => $this->period_from,
            'period_to' => $this->period_to,
            'added_date' => $this->added_date,
        ]);

        $query->andFilterWhere(['like', 'receivable_amount', $this->receivable_amount])
            ->andFilterWhere(['like', 'receivable_category', $this->receivable_category])
            ->andFilterWhere(['like', 'project_name', $this->project])
            ->andFilterWhere(['like', 'payer_name', $this->payer_name])
            ->andFilterWhere(['like', 'added_by', $this->added_by])
            ->andFilterWhere(['like', 'receivable_status', $this->receivable_status])
            ->andFilterWhere(['like', 'receivable_description', $this->receivable_description]);

        return $dataProvider;
    }
}
