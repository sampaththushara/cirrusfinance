<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblPayable;

/**
 * TblPayableSearch represents the model behind the search form of `app\models\TblPayable`.
 */
class TblPayableSearch extends TblPayable
{
    /**
     * {@inheritdoc}
     */
    public $project_name;
    public $payee_name;

    public function rules()
    {
        return [
            [['payable_id', 'project_id', 'payee_id'], 'integer'],
            [['project_name', 'payee_name', 'due_date', 'description', 'expense_category', 'period_from', 'period_to', 'added_date', 'added_by', 'payable_status', 'payable_amount'], 'safe'],
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
        $query = TblPayable::find();

        // add conditions that should always apply here
        $query->joinWith(['project', 'payee']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['project_name'] = [
            'asc' => ['acc_business.business_name' => SORT_ASC],
            'desc' => ['acc_business.business_name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['payee_name'] = [
            'asc' => ['payee_master.payee_name' => SORT_ASC],
            'desc' => ['payee_master.payee_name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'payable_id' => $this->payable_id,
            'due_date' => $this->due_date,
            'payable_amount' => $this->payable_amount,
            'period_from' => $this->period_from,
            'period_to' => $this->period_to,
            'added_date' => $this->added_date,
        ]);

        $query->andFilterWhere(['like', 'payable_amount', $this->payable_amount])
            ->andFilterWhere(['like', 'expense_category', $this->expense_category])
            ->andFilterWhere(['like', 'project_name', $this->project])
            ->andFilterWhere(['like', 'payee_name', $this->payee_name])
            ->andFilterWhere(['like', 'added_by', $this->added_by])
            ->andFilterWhere(['like', 'payable_status', $this->payable_status])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

}
