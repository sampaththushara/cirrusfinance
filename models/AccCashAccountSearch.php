<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AccCashAccount;

/**
 * AccCashAccountSearch represents the model behind the search form of `app\models\AccCashAccount`.
 */
class AccCashAccountSearch extends AccCashAccount
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['account_id', 'business_id'], 'integer'],
            [['account_name', 'account_code', 'account_status'], 'safe'],
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
        $query = AccCashAccount::find();

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
            'account_id' => $this->account_id,
            'business_id' => $this->business_id,
        ]);

        $query->andFilterWhere(['like', 'account_name', $this->account_name])
            ->andFilterWhere(['like', 'account_code', $this->account_code])
            ->andFilterWhere(['like', 'account_status', $this->account_status]);

        return $dataProvider;
    }
}
