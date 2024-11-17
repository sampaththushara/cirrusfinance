<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acc_entry_main".
 *
 * @property int $entry_id
 * @property string $ref_no
 * @property string $entry_date
 * @property double $dr_total
 * @property double $cr_total
 * @property string $narration
 * @property int $business_id
 * @property string $entry_type
 *
 * @property AccEntryDetail[] $accEntryDetails
 * @property AccBusiness $business
 */
class AccEntryMain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acc_entry_main';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entry_date'], 'safe'],
            [['dr_total', 'cr_total'], 'number'],
            [['business_id'], 'integer'],
            [['ref_no', 'entry_type'], 'string', 'max' => 50],
            [['narration'], 'string', 'max' => 150],
            [['business_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccBusiness::className(), 'targetAttribute' => ['business_id' => 'business_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'entry_id' => 'Entry ID',
            'ref_no' => 'Ref No',
            'entry_date' => 'Entry Date',
            'dr_total' => 'Dr Total',
            'cr_total' => 'Cr Total',
            'narration' => 'Narration',
            'business_id' => 'Business ID',
            'entry_type' => 'Entry Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccEntryDetails()
    {
        return $this->hasMany(AccEntryDetail::className(), ['entry_id' => 'entry_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusiness()
    {
        return $this->hasOne(AccBusiness::className(), ['business_id' => 'business_id']);
    }
}
