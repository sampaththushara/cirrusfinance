<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acc_payment_projects".
 *
 * @property int $pay_proj_id
 * @property int $business_id
 * @property double $paid_amount
 * @property int $pay_main_id
 *
 * @property AccBusiness $business
 * @property AccPaymentMain $payMain
 */
class AccPaymentProjects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $payable_or_check_id;


    public static function tableName()
    {
        return 'acc_payment_projects';
    }
    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['business_id', 'pay_main_id'], 'integer'],
            [['paid_amount', 'pay_main_id'], 'required'],
            [['paid_amount'], 'number'],
            [['business_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccBusiness::className(), 'targetAttribute' => ['business_id' => 'business_id']],
            [['pay_main_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccPaymentMain::className(), 'targetAttribute' => ['pay_main_id' => 'pmt_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pay_proj_id' => 'Pay Proj ID',
            'business_id' => 'Project',
            'paid_amount' => 'Paid Amount',
            'pay_main_id' => 'Pay Main ID',
        ];
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
    public function getPayMain()
    {
        return $this->hasOne(AccPaymentMain::className(), ['pmt_id' => 'pay_main_id']);
    }
}
