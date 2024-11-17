<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acc_receipt_detail".
 *
 * @property int $rpt_detail_id
 * @property int $chart_of_acc_id
 * @property string $rpt_detail_desc
 * @property double $quantity
 * @property double $unit_price
 * @property double $line_total
 * @property int $rpt_main_id
 *
 * @property AccReceiptMain $rptMain
 * @property CaGroup $chartOfAcc
 */
class AccReceiptDetail extends \yii\db\ActiveRecord
{
    public $subcontractor;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acc_receipt_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chart_of_acc_id','line_total'], 'required'],
            [['rpt_detail_id', 'chart_of_acc_id', 'rpt_main_id'], 'integer'],
            [['quantity', 'unit_price', 'line_total'], 'number'],
            [['rpt_detail_desc'], 'string', 'max' => 150],
            [['rpt_detail_id'], 'unique'],
            [['rpt_main_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccReceiptMain::className(), 'targetAttribute' => ['rpt_main_id' => ' rpt_id']],
            [['chart_of_acc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CaGroup::className(), 'targetAttribute' => ['chart_of_acc_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rpt_detail_id' => 'Rpt Detail ID',
            'chart_of_acc_id' => 'Chart Of Account',
            'rpt_detail_desc' => 'Rpt Detail Desc',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'line_total' => 'Amount',
            'rpt_main_id' => 'Rpt Main ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRptMain()
    {
        return $this->hasOne(AccReceiptMain::className(), [' rpt_id' => 'rpt_main_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChartOfAcc()
    {
        return $this->hasOne(CaGroup::className(), ['id' => 'chart_of_acc_id']);
    }
}
