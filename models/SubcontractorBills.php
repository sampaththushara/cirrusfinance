<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subcontractor_bills".
 *
 * @property int $bill_id
 * @property int $page_id
 * @property string $payee_name
 * @property double $bill_amount
 * @property string $bill_date
 * @property int $business_id
 * @property string $received_date
 * @property string $bill_status
 *
 * @property Invoice[] $invoices
 * @property AccBusiness $business
 */
class SubcontractorBills extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subcontractor_bills';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page_id', 'payee_name', 'bill_amount', 'bill_date', 'received_date', 'bill_status'], 'required'],
            [['page_id', 'business_id'], 'integer'],
            [['bill_amount'], 'number'],
            [['bill_date', 'received_date'], 'safe'],
            [['payee_name'], 'string', 'max' => 100],
            [['bill_status'], 'string', 'max' => 10],
            [['business_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccBusiness::className(), 'targetAttribute' => ['business_id' => 'business_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bill_id' => 'Bill ID',
            'page_id' => 'Page ID',
            'payee_name' => 'Payee Name',
            'bill_amount' => 'Bill Amount',
            'bill_date' => 'Bill Date',
            'business_id' => 'Business ID',
            'received_date' => 'Received Date',
            'bill_status' => 'Bill Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['bill_id' => 'bill_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusiness()
    {
        return $this->hasOne(AccBusiness::className(), ['business_id' => 'business_id']);
    }
}
