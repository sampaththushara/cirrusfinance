<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VehicleExpenseMaster;

/**
 * VehicleExpenseMasterSearch represents the model behind the search form of `app\models\VehicleExpenseMaster`.
 */
class VehicleExpenseMasterSearch extends VehicleExpenseMaster
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehicle_exp_id'], 'integer'],
            [['vehicle_expense_category', 'expense_status'], 'safe'],
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
        $query = VehicleExpenseMaster::find();

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
            'vehicle_exp_id' => $this->vehicle_exp_id,
        ]);

        $query->andFilterWhere(['like', 'vehicle_expense_category', $this->vehicle_expense_category])
            ->andFilterWhere(['like', 'expense_status', $this->expense_status]);

        return $dataProvider;
    }
}
