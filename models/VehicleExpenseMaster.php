<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicle_expense_master".
 *
 * @property int $vehicle_exp_id
 * @property string $vehicle_expense_category
 * @property string $expense_status
 *
 * @property VehicleTransaction[] $vehicleTransactions
 */
class VehicleExpenseMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle_expense_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehicle_expense_category'], 'required'],
            [['vehicle_expense_category'], 'string', 'max' => 50],
            [['expense_status'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'vehicle_exp_id' => 'Vehicle Exp ID',
            'vehicle_expense_category' => 'Vehicle Expense Category',
            'expense_status' => 'Expense Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleTransactions()
    {
        return $this->hasMany(VehicleTransaction::className(), ['vehicle_exp_id' => 'vehicle_exp_id']);
    }
}
