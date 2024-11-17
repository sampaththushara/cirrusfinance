<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicle_transaction".
 *
 * @property int $vehicle_transaction_id
 * @property int $vehicle_id
 * @property int $vehicle_exp_id
 * @property double $amount
 * @property string $added_by
 * @property string $added_date
 *
 * @property Vehicles $vehicle
 * @property VehicleExpenseMaster $vehicleExp
 */
class VehicleTransaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle_transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehicle_id', 'vehicle_exp_id', 'amount'], 'required'],
            [['vehicle_id', 'vehicle_exp_id', 'payable_id'], 'integer'],
            [['amount'], 'number'],
            [['added_date'], 'safe'],
            [['status'], 'string', 'max' => 50],
            [['added_by'], 'string', 'max' => 50],
            [['vehicle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehicles::className(), 'targetAttribute' => ['vehicle_id' => 'vehicle_id']],
            [['vehicle_exp_id'], 'exist', 'skipOnError' => true, 'targetClass' => VehicleExpenseMaster::className(), 'targetAttribute' => ['vehicle_exp_id' => 'vehicle_exp_id']],
            [['payable_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblPayable::className(), 'targetAttribute' => ['payable_id' => 'payable_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'vehicle_transaction_id' => 'Vehicle Transaction ID',
            'vehicle_id' => 'Vehicle ID',
            'vehicle_exp_id' => 'Vehicle Exp ID',
            'amount' => 'Amount',
            'payable_id' => 'Payable ID',
            'status' => 'Status',
            'added_by' => 'Added By',
            'added_date' => 'Added Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicle()
    {
        return $this->hasOne(Vehicles::className(), ['vehicle_id' => 'vehicle_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleExp()
    {
        return $this->hasOne(VehicleExpenseMaster::className(), ['vehicle_exp_id' => 'vehicle_exp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayable()
    {
        return $this->hasOne(TblPayable::className(), ['payable_id' => 'payable_id']);
    }
}
