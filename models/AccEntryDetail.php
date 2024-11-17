<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acc_entry_detail".
 *
 * @property int $entry_detail_id
 * @property int $char_of_acc_id
 * @property double $entry_amount
 * @property string $dr_cr
 * @property string $reconcilation_date
 * @property int $entry_id
 *
 * @property CaGroup $charOfAcc
 * @property AccEntryMain $entry
 */
class AccEntryDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acc_entry_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['char_of_acc_id', 'entry_amount', 'dr_cr'], 'required'],
            [['char_of_acc_id', 'entry_id'], 'integer'],
            [['entry_amount'], 'number'],
            [['reconcilation_date'], 'safe'],
            [['dr_cr'], 'string', 'max' => 1],
            [['char_of_acc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CaGroup::className(), 'targetAttribute' => ['char_of_acc_id' => 'id']],
            [['entry_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccEntryMain::className(), 'targetAttribute' => ['entry_id' => 'entry_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'entry_detail_id' => 'Entry Detail ID',
            'char_of_acc_id' => 'Char Of Acc ID',
            'entry_amount' => 'Entry Amount',
            'dr_cr' => 'Dr Cr',
            'reconcilation_date' => 'Reconcilation Date',
            'entry_id' => 'Entry ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharOfAcc()
    {
        return $this->hasOne(CaGroup::className(), ['id' => 'char_of_acc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntry()
    {
        return $this->hasOne(AccEntryMain::className(), ['entry_id' => 'entry_id']);
    }
}
