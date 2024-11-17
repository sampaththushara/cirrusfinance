<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acc_cash_account".
 *
 * @property int $account_id
 * @property string $account_name
 * @property string $account_code
 * @property string $account_status
 * @property int $business_id
 *
 * @property AccBusiness $business
 */
class AccCashAccount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acc_cash_account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['account_id', 'account_name'], 'required'],
            [['account_id', 'business_id', 'account_type_id'], 'integer'],
            [['account_name'], 'string', 'max' => 100],
            [['account_code'], 'string', 'max' => 20],
            [['account_status'], 'string', 'max' => 1],
            [['account_id'], 'unique'],
            [['business_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccBusiness::className(), 'targetAttribute' => ['business_id' => 'business_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'account_id' => 'Account ID',
            'account_name' => 'Account Name',
            'account_code' => 'Account Code',
            'account_status' => 'Account Status',
            'business_id' => 'Project',
            'account_type_id' => 'Account Type'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusiness()
    {
        return $this->hasOne(AccBusiness::className(), ['business_id' => 'business_id']);
    }
}
