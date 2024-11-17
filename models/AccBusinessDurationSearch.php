<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AccBusinessDuration;

/**
 * AccBusinessDurationSearch represents the model behind the search form of `app\models\AccBusinessDuration`.
 */
class AccBusinessDurationSearch extends AccBusinessDuration
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['duration_id', 'business_id', 'duration_status'], 'integer'],
            [['business_from'], 'safe'],
            [['business_to'], 'number'],
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
        $query = AccBusinessDuration::find();

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
            'duration_id' => $this->duration_id,
            'business_from' => $this->business_from,
            'business_to' => $this->business_to,
            'business_id' => $this->business_id,
            'duration_status' => $this->duration_status,
        ]);

        return $dataProvider;
    }
}
