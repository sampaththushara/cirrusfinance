<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment_application".
 *
 * @property int $id
 * @property string $client_name
 * @property string $client_address
 * @property double $amount
 * @property string $invoice_status
 * @property double $retention_amount
 */
class PaymentApplication extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'Client_Code', 'amount', 'invoice_status', 'retention_amount'], 'required'],
            [['id', 'Client_Code', 'Client_ID_PMS'], 'integer'],
            [['amount', 'retention_amount'], 'number'],
            [['client_address', 'particulars'], 'string', 'max' => 200],
            [['invoice_status'], 'string', 'max' => 20],
            [['added_by'], 'string', 'max' => 50],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Client_Code' => 'Client Code',
            'Client_ID_PMS' => 'Client ID PMS',
            'client_address' => 'Client Address',
            'particulars' => 'Particulars',
            'amount' => 'Amount',
            'invoice_status' => 'Invoice Status',
            'retention_amount' => 'Retention Amount',
            'added_by' => 'Added By',
        ];
    }
}
