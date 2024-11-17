<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acc_payer_payee_details".
 *
 * @property int $payee_id
 * @property string $payer_name
 * @property string $payer_status
 */
class AccPayerPayeeDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acc_payer_payee_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payer_name'], 'required'],
            [['payer_name'], 'string', 'max' => 150],
            [['payer_status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'payee_id' => 'Payee ID',
            'payer_name' => 'Payer Name',
            'payer_status' => 'Payer Status',
        ];
    }
}
