<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property int $invoice_id
 * @property string $invoice_date
 * @property string $client_name
 * @property double $VAT
 * @property double $NBT
 * @property int $business_id
 * @property int $bill_id
 * @property string $invoice_created_by
 * @property string $created_date
 *
 * @property SubcontractorBills $bill
 * @property AccBusiness $business
 * @property InvoiceDetail[] $invoiceDetails
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invoice_id', 'invoice_date',  'created_date', 'tot_invoice_amount'], 'required'],
            [['invoice_date', 'created_date'], 'safe'],
            [['VAT', 'NBT', 'tot_invoice_amount', 'receipt_balance'], 'number'],
            [['invoice_id', 'business_id', 'bill_id'], 'integer'],
            [['invoice_created_by'], 'string', 'max' => 100],
            [['bill_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubcontractorBills::className(), 'targetAttribute' => ['bill_id' => 'bill_id']],
            [['business_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccBusiness::className(), 'targetAttribute' => ['business_id' => 'business_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'invoice_id' => 'Invoice ID',
            'invoice_date' => 'Invoice Date',
            'VAT' => 'Vat',
            'NBT' => 'Nbt',
            'tot_invoice_amount' => 'Total Invoice Amount',
            'receipt_balance' => 'Receipt Balance',
            'business_id' => 'Business ID',
            'bill_id' => 'Bill ID',
            'invoice_created_by' => 'Invoice Created By',
            'created_date' => 'Created Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBill()
    {
        return $this->hasOne(SubcontractorBills::className(), ['bill_id' => 'bill_id']);
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
    public function getInvoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::className(), ['invoice_id' => 'invoice_id']);
    }
}
