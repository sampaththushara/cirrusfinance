<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CompanyMaster;

/**
 * CompanyMasterSearch represents the model behind the search form of `app\models\CompanyMaster`.
 */
class CompanyMasterSearch extends CompanyMaster
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['company_legal_name', 'company_reg_no', 'incorporation_date', 'financial_year', 'tin_no', 'vat_svat_no', 'nbt_reg_no', 'epf_etf_reg_no', 'payee_tax_no', 'address', 'image'], 'safe'],
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
        $query = CompanyMaster::find();

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
            'incorporation_date' => $this->incorporation_date,
        ]);

        $query->andFilterWhere(['like', 'company_legal_name', $this->company_legal_name])
            ->andFilterWhere(['like', 'company_reg_no', $this->company_reg_no])
            ->andFilterWhere(['like', 'financial_year', $this->financial_year])
            ->andFilterWhere(['like', 'tin_no', $this->tin_no])
            ->andFilterWhere(['like', 'vat_svat_no', $this->vat_svat_no])
            ->andFilterWhere(['like', 'nbt_reg_no', $this->nbt_reg_no])
            ->andFilterWhere(['like', 'epf_etf_reg_no', $this->epf_etf_reg_no])
            ->andFilterWhere(['like', 'payee_tax_no', $this->payee_tax_no]);

        return $dataProvider;
    }
}
