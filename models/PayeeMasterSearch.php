<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PayeeMaster;

/**
 * PayeeMasterSearch represents the model behind the search form of `app\models\PayeeMaster`.
 */
class PayeeMasterSearch extends PayeeMaster
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payee_id'], 'integer'],
            [['payee_name', 'payee_status'], 'safe'],
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
        $query = PayeeMaster::find();

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
            'payee_id' => $this->payee_id,
        ]);

        $query->andFilterWhere(['like', 'payee_name', $this->payee_name])
            ->andFilterWhere(['like', 'payee_status', $this->payee_status]);

        return $dataProvider;
    }
}
