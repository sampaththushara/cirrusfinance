<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Vehicles;

/**
 * VehiclesSearch represents the model behind the search form of `app\models\Vehicles`.
 */
class VehiclesSearch extends Vehicles
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehicle_id'], 'integer'],
            [['vehicle_number', 'added_by', 'added_date'], 'safe'],
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
        $query = Vehicles::find();

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
            'vehicle_id' => $this->vehicle_id,
            'added_date' => $this->added_date,
        ]);

        $query->andFilterWhere(['like', 'vehicle_number', $this->vehicle_number])
            ->andFilterWhere(['like', 'added_by', $this->added_by]);

        return $dataProvider;
    }
}
