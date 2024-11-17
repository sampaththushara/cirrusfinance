<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblActionsLog;

/**
 * TblActionsLogSearch represents the model behind the search form of `app\models\TblActionsLog`.
 */
class TblActionsLogSearch extends TblActionsLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'student_id'], 'integer'],
            [['index_no', 'action_summary', 'action_taken', 'added_by', 'added_date'], 'safe'],
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
        $query = TblActionsLog::find();

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
            'id' => $this->id,
            'student_id' => $this->student_id,
            'added_date' => $this->added_date,
        ]);

        $query->andFilterWhere(['like', 'index_no', $this->index_no])
            ->andFilterWhere(['like', 'action_summary', $this->action_summary])
            ->andFilterWhere(['like', 'action_taken', $this->action_taken])
            ->andFilterWhere(['like', 'added_by', $this->added_by]);

        return $dataProvider;
    }
}
