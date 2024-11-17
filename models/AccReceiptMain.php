<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acc_receipt_main".
 *
 * @property int $rpt_id
 * @property string $reference_no
 * @property int $account_id
 * @property string $payer_name
 * @property string $description
 * @property double $tot_receipt_amount
 * @property string $added_by
 * @property string $added_date
 * @property int $business_id
 *
 * @property AccReceiptDetail[] $accReceiptDetails
 * @property CaGroup $account
 * @property AccBusiness $business
 */
class AccReceiptMain extends \yii\db\ActiveRecord
{
    public $ca_code;
    public $statement_amount;
    public $statement_date;
    public $tot_invoice_amount;
    public $receipt_balance;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acc_receipt_main';
    }

    /**
     * {@inheritdoc}
     */

   

    public function rules()
    {
        return [
            [['receipt_date', 'business_id'], 'required'],
            [['rpt_id', 'account_id', 'business_id', 'invoice_id'], 'integer'],
            [['tot_receipt_amount'], 'number'],
            [['added_date','receipt_date'], 'safe'],
            [['reference_no', 'added_by'], 'string', 'max' => 50],
            [['payer_name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 200],
            [['rpt_id'], 'unique'],
            [['receipt_type'], 'string', 'max' => 10],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => CaGroup::className(), 'targetAttribute' => ['account_id' => 'id']],
            [['business_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccBusiness::className(), 'targetAttribute' => ['business_id' => 'business_id']],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::className(), 'targetAttribute' => ['invoice_id' => 'invoice_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rpt_id' => 'Rpt ID',
            'reference_no' => 'Reference No',
            'account_id' => 'Account',
            'payer_name' => 'Payer Name',
            'description' => 'Description',
            'tot_receipt_amount' => 'Total Amount',
            'added_by' => 'Added By',
            'added_date' => 'Added Date',
            'business_id' => 'Project',
            'invoice_id' => 'Invoice',
            'receipt_date' => 'Receipt Date',
            'receipt_type' => 'Receipt Type'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccReceiptDetails()
    {
        return $this->hasMany(AccReceiptDetail::className(), ['rpt_main_id' => 'rpt_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(CaGroup::className(), ['id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusiness()
    {
        return $this->hasOne(AccBusiness::className(), ['business_id' => 'business_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['invoice_id' => 'invoice_id']);
    }

   
}
