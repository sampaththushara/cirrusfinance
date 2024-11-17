<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acc_journal_detail".
 *
 * @property int $journal_detail_id
 * @property int $chart_of_acc_id
 * @property string $journal_detail_desc
 * @property double $quantity
 * @property double $unit_price
 * @property double $line_total
 * @property int $journal_main_id
 *
 * @property CaGroup $chartOfAcc
 * @property AccJournalMain $journalMain
 */
class Journaldetail extends \yii\db\ActiveRecord
{
    public $subcontractor;
    public $refresh;
    public $coa_category;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acc_journal_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chart_of_acc_id', 'line_total','dr_or_cr'], 'required'],
            [['chart_of_acc_id', 'journal_main_id'], 'integer'],
            [['quantity', 'unit_price'], 'number'],
            [['journal_detail_desc'], 'string', 'max' => 150],
            //[['dr_or_cr'], 'string', 'max' => 2],            
            [['chart_of_acc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CaGroup::className(), 'targetAttribute' => ['chart_of_acc_id' => 'id']],
            [['journal_main_id'], 'exist', 'skipOnError' => true, 'targetClass' => Journalmain::className(), 'targetAttribute' => ['journal_main_id' => 'journal_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'journal_detail_id' => 'Journal Detail ID',
            'chart_of_acc_id' => 'Chart Of Account',
            'journal_detail_desc' => 'Journal Detail Desc',
            'dr_or_cr' => 'Debit/Credit',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'line_total' => 'Amount',
            'journal_main_id' => 'Journal Main ID',
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
    public function getJournalMain()
    {
        return $this->hasOne(AccJournalMain::className(), ['journal_id' => 'journal_main_id']);
    }
}
