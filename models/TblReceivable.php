<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_receivable".
 *
 * @property int $receivable_id
 * @property int $project_id
 * @property string $due_date
 * @property int $payer_id
 * @property string $receivable_description
 * @property string $receivable_category
 * @property string $period_from
 * @property string $period_to
 * @property string $added_date
 * @property string $added_by
 * @property string $receivable_status
 *
 * @property AccBusiness $project
 * @property PayerMaster $payer
 */
class TblReceivable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_receivable';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'due_date', 'payer_id', 'period_from', 'period_to', 'receivable_status', 'receivable_amount'], 'required'],
            [['project_id', 'payer_id'], 'integer'],
            [['due_date', 'period_from', 'period_to', 'added_date'], 'safe'],
            [['receivable_description'], 'string', 'max' => 200],
            [['receivable_category', 'added_by', 'receivable_status'], 'string', 'max' => 50],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccBusiness::className(), 'targetAttribute' => ['project_id' => 'business_id']],
            [['payer_id'], 'exist', 'skipOnError' => true, 'targetClass' => PayerMaster::className(), 'targetAttribute' => ['payer_id' => 'payer_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'receivable_id' => 'Receivable ID',
            'project_id' => 'Project ID',
            'due_date' => 'Due Date',
            'payer_id' => 'Payer ID',
            'receivable_amount' => 'Receivable Amount',
            'receivable_description' => 'Receivable Description',
            'receivable_category' => 'Receivable Category',
            'period_from' => 'Period From',
            'period_to' => 'Period To',
            'added_date' => 'Added Date',
            'added_by' => 'Added By',
            'receivable_status' => 'Receivable Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(AccBusiness::className(), ['business_id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayer()
    {
        return $this->hasOne(PayerMaster::className(), ['payer_id' => 'payer_id']);
    }
}
