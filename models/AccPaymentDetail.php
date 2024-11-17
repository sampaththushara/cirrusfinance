<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acc_payment_detail".
 *
 * @property int $pmt_detail_id
 * @property int $chart_of_acc_id
 * @property string $pmt_detail_desc
 * @property double $quantity
 * @property double $unit_price
 * @property double $line_total
 * @property int $pmt_main_id
 *
 * @property CaGroup $chartOfAcc
 * @property AccPaymentMain $pmtMain
 */
class AccPaymentDetail extends \yii\db\ActiveRecord
{
    public $subcontractor;
    public $coa_category;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acc_payment_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chart_of_acc_id', 'line_total'], 'required'],
            [['chart_of_acc_id', 'pmt_main_id'], 'integer'],
            [['quantity', 'unit_price', 'line_total'], 'number'],
            [['pmt_detail_desc'], 'string', 'max' => 150],
            [['chart_of_acc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CaGroup::className(), 'targetAttribute' => ['chart_of_acc_id' => 'id']],
            [['pmt_main_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccPaymentMain::className(), 'targetAttribute' => ['pmt_main_id' => 'pmt_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pmt_detail_id' => 'Pmt Detail ID',
            'chart_of_acc_id' => 'Chart Of Acc ID',
            'pmt_detail_desc' => 'Pmt Detail Desc',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'line_total' => 'Amount',
            'pmt_main_id' => 'Pmt Main ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChartOfAcc()
    {
        return $this->hasOne(CaGroup::className(), ['id' => 'chart_of_acc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPmtMain()
    {
        return $this->hasOne(AccPaymentMain::className(), ['pmt_id' => 'pmt_main_id']);
    }
}
