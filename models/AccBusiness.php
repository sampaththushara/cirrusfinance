<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acc_business".
 *
 * @property int $business_id
 * @property string $business_name
 * @property int $status
 *
 * @property AccBankCashAccount[] $accBankCashAccounts
 * @property AccBusinessDuration[] $accBusinessDurations
 * @property AccEntryMain[] $accEntryMains
 * @property AccReceiptMain[] $accReceiptMains
 */
class AccBusiness extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acc_business';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['business_id', 'status'], 'integer'],
            [['business_name'], 'string', 'max' => 100],
            [['business_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'business_id' => 'Project ID',
            'business_name' => 'Project Name',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccBankCashAccounts()
    {
        return $this->hasMany(AccBankCashAccount::className(), ['business_id' => 'business_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccBusinessDurations()
    {
        return $this->hasMany(AccBusinessDuration::className(), ['business_id' => 'business_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccEntryMains()
    {
        return $this->hasMany(AccEntryMain::className(), ['business_id' => 'business_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccReceiptMains()
    {
        return $this->hasMany(AccReceiptMain::className(), ['business_id' => 'business_id']);
    }
}
