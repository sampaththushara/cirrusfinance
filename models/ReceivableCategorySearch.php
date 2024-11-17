<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ReceivableCategory;

/**
 * ReceivableCategorySearch represents the model behind the search form of `app\models\ReceivableCategory`.
 */
class ReceivableCategorySearch extends ReceivableCategory
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Receivable_Cat_ID'], 'integer'],
            [['Receivable_Category', 'Cat_Status'], 'safe'],
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
        $query = ReceivableCategory::find();

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
            'Receivable_Cat_ID' => $this->Receivable_Cat_ID,
        ]);

        $query->andFilterWhere(['like', 'Receivable_Category', $this->Receivable_Category])
            ->andFilterWhere(['like', 'Cat_Status', $this->Cat_Status]);

        return $dataProvider;
    }
}
