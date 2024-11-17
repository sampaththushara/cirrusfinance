<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicles".
 *
 * @property int $vehicle_id
 * @property string $vehicle_number
 * @property string $added_by
 * @property string $added_date
 *
 * @property VehicleTransaction[] $vehicleTransactions
 */
class Vehicles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehicle_number'], 'required'],
            [['added_date'], 'safe'],
            [['vehicle_number'], 'string', 'max' => 20],
            [['added_by'], 'string', 'max' => 50],
            [['vehicle_number'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'vehicle_id' => 'Vehicle ID',
            'vehicle_number' => 'Vehicle Number',
            'added_by' => 'Added By',
            'added_date' => 'Added Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleTransactions()
    {
        return $this->hasMany(VehicleTransaction::className(), ['vehicle_id' => 'vehicle_id']);
    }
}
