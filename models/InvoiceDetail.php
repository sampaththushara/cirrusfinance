<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoice_detail".
 *
 * @property int $invoice_detail_id
 * @property int $payment_application_id
 * @property int $invoice_id
 *
 * @property Invoice $invoice
 * @property PaymentApplication $paymentApplication
 */
class InvoiceDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payment_application_id', 'invoice_id'], 'required'],
            [['payment_application_id', 'invoice_id'], 'integer'],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::className(), 'targetAttribute' => ['invoice_id' => 'invoice_id']],
            [['payment_application_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentApplication::className(), 'targetAttribute' => ['payment_application_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'invoice_detail_id' => 'Invoice Detail ID',
            'payment_application_id' => 'Payment Application ID',
            'invoice_id' => 'Invoice ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['invoice_id' => 'invoice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentApplication()
    {
        return $this->hasOne(PaymentApplication::className(), ['id' => 'payment_application_id']);
    }
}
