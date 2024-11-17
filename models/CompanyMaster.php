<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company_master".
 *
 * @property int $id
 * @property string $company_legal_name
 * @property string $company_reg_no
 * @property string $incorporation_date
 * @property string $financial_year
 * @property string $tin_no
 * @property string $vat_svat_no
 * @property string $nbt_reg_no
 * @property string $epf_etf_reg_no
 * @property string $payee_tax_no
 */
class CompanyMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_legal_name', 'company_reg_no', 'incorporation_date', 'financial_year', 'tin_no', 'vat_svat_no', 'nbt_reg_no', 'epf_etf_reg_no', 'payee_tax_no'], 'required'],
            [['incorporation_date'], 'safe'],
            [['company_legal_name'], 'string', 'max' => 150],
            [['company_reg_no', 'financial_year', 'tin_no', 'vat_svat_no', 'nbt_reg_no', 'epf_etf_reg_no', 'payee_tax_no', 'address', 'image'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_legal_name' => 'Company Legal Name',
            'company_reg_no' => 'Company Reg No',
            'incorporation_date' => 'Incorporation Date',
            'financial_year' => 'Financial Year',
            'tin_no' => 'TIN No',
            'vat_svat_no' => 'VAT SVAT No',
            'nbt_reg_no' => 'NBT Reg No',
            'epf_etf_reg_no' => 'EPF ETF Reg No',
            'payee_tax_no' => 'Payee Tax No',
            'address' => 'Address',
        ];
    }
}
