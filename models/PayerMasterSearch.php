<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PayerMaster;

/**
 * PayerMasterSearch represents the model behind the search form of `app\models\PayerMaster`.
 */
class PayerMasterSearch extends PayerMaster
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payer_id'], 'integer'],
            [['payer_name', 'payer_status'], 'safe'],
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
        $query = PayerMaster::find();

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
            'payer_id' => $this->payer_id,
        ]);

        $query->andFilterWhere(['like', 'payer_name', $this->payer_name])
            ->andFilterWhere(['like', 'payer_status', $this->payer_status]);

        return $dataProvider;
    }
}
