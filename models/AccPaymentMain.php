<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acc_payment_main".
 *
 * @property int $pmt_id
 * @property string $reference_no
 * @property int $account_id
 * @property string $payee_name
 * @property string $description
 * @property double $tot_payment_amount
 * @property string $added_by
 * @property string $added_date
 * @property int $business_id
 * @property int $business_duration_id
 * @property string $payment_date
 *
 * @property AccPaymentDetail[] $accPaymentDetails
 * @property AccBusiness $business
 * @property CaGroup $account
 */
class AccPaymentMain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acc_payment_main';
    }

    /**
     * {@inheritdoc}
     */

    public $post_dated_chq_id;
    public $payable_id;

    public function rules()
    {
        return [
            [['account_id', 'business_duration_id'], 'integer'],
            [['tot_payment_amount'], 'number'],
            [['added_date', 'payment_date'], 'safe'],
            [['reference_no', 'po_reference', 'added_by'], 'string', 'max' => 50],
            [['payee_name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 200],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => CaGroup::className(), 'targetAttribute' => ['account_id' => 'id']],
            [['post_dated_chq_id'], 'exist', 'skipOnError' => true, 'targetClass' => PostDatedCheque::className(), 'targetAttribute' => ['post_dated_chq_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pmt_id' => 'Pmt ID',
            'reference_no' => 'Reference No',
            'po_reference' => 'PO Reference No',
            'account_id' => 'Account',
            'payee_name' => 'Payee Name',
            'description' => 'Description',
            'tot_payment_amount' => 'Tot Payment Amount',
            'added_by' => 'Added By',
            'added_date' => 'Added Date',
            'business_duration_id' => 'Business Duration ID',
            'payment_date' => 'Payment Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccPaymentDetails()
    {
        return $this->hasMany(AccPaymentDetail::className(), ['pmt_main_id' => 'pmt_id']);
    }

    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(CaGroup::className(), ['id' => 'account_id']);
    }
}
