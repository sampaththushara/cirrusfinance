<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acc_journal_main".
 *
 * @property int $journal_id
 * @property string $reference_no
 * @property string $description
 * @property double $tot_journal_amount
 * @property string $added_by
 * @property string $added_date
 * @property int $business_id
 * @property int $business_duration_id
 * @property string $journal_date
 *
 * @property AccJournalDetail[] $accJournalDetails
 * @property AccBusiness $business
 */
class Journalmain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acc_journal_main';
    }

    /**
     * {@inheritdoc}
     */

    public $dr_tot;
    public $cr_tot;

    public function rules()
    {
        return [
            [['tot_journal_amount','tot_journal_cr','tot_journal_dr'], 'number'],
            [['tot_journal_amount'], 'number'],
            [['journal_date'], 'required'],
            [['added_date'], 'safe'],
            [['business_id', 'business_duration_id'], 'integer'],
            [['reference_no', 'added_by'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 200],
            [['business_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccBusiness::className(), 'targetAttribute' => ['business_id' => 'business_id']],
            [['dr_tot','cr_tot'],'my_required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'journal_id' => 'Journal ID',
            'reference_no' => 'Reference No',
            'description' => 'Description',
            'tot_journal_amount' => 'Tot Journal Amount',
            'added_by' => 'Added By',
            'added_date' => 'Added Date',
            'business_id' => 'Project',
            'business_duration_id' => 'Business Duration ID',
            'journal_date' => 'Journal Date',
            'tot_journal_cr' => 'Cr',
            'tot_journal_dr' => 'Dr',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccJournalDetails()
    {
        return $this->hasMany(AccJournalDetail::className(), ['journal_main_id' => 'journal_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusiness()
    {
        return $this->hasOne(AccBusiness::className(), ['business_id' => 'business_id']);
    }


    public function my_required($attribute_name, $params)
    {
        /*if (empty($this->dr_tot) OR empty($this->cr_tot)) {
            $this->addError($attribute_name,'Dr or Cr empty');
            return false;
            
        }*/
        if ($this->dr_tot != $this->cr_tot) {
            $this->addError($attribute_name,'Dr total and Cr total not diffrence.');
            return false;
        }

        return true;

    }
}
