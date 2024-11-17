<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_payable".
 *
 * @property int $payable_id
 * @property int $project_id
 * @property string $due_date
 * @property int $payee_id
 * @property string $description
 * @property string $expense_category
 * @property string $period_from
 * @property string $period_to
 * @property string $added_date
 * @property string $added_by
 * @property string $payable_status
 *
 * @property PayeeMaster $payee
 * @property AccBusiness $project
 */
class TblPayable extends \yii\db\ActiveRecord
{

    public $vehicle_number;
    public $vehicle_expense_category;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_payable';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'payee_id', 'period_from', 'period_to', 'payable_status', 'payable_amount'], 'required'],
            [['project_id', 'payee_id'], 'integer'],
            [['due_date', 'period_from', 'period_to', 'added_date'], 'safe'],
            [['description'], 'string', 'max' => 200],
            [['expense_category', 'added_by', 'payable_status'], 'string', 'max' => 50],
            [['payee_id'], 'exist', 'skipOnError' => true, 'targetClass' => PayeeMaster::className(), 'targetAttribute' => ['payee_id' => 'payee_id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccBusiness::className(), 'targetAttribute' => ['project_id' => 'business_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'payable_id' => 'Payable ID',
            'project_id' => 'Project ID',
            'due_date' => 'Due Date',
            'payee_id' => 'Payee ID',
            'payable_amount' => 'Payable Amount',
            'description' => 'Description',
            'expense_category' => 'Expense Category',
            'period_from' => 'Period From',
            'period_to' => 'Period To',
            'added_date' => 'Added Date',
            'added_by' => 'Added By',
            'payable_status' => 'Payable Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayee()
    {
        return $this->hasOne(PayeeMaster::className(), ['payee_id' => 'payee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(AccBusiness::className(), ['business_id' => 'project_id']);
    }
}
