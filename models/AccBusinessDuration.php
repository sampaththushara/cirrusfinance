<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acc_business_duration".
 *
 * @property int $duration_id
 * @property string $business_from
 * @property double $business_to
 * @property int $business_id
 * @property int $duration_status
 *
 * @property AccBusiness $business
 */
class AccBusinessDuration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acc_business_duration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['business_from', 'business_to', 'duration_status'], 'required'],
            [['duration_id', 'business_id', 'duration_status'], 'integer'],
            [['business_from','business_to'], 'safe'],
            [['duration_id'], 'unique'],
            [['business_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccBusiness::className(), 'targetAttribute' => ['business_id' => 'business_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'duration_id' => 'Duration ID',
            'business_from' => 'From',
            'business_to' => 'To',
            'business_id' => 'Business ID',
            'duration_status' => 'Duration Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusiness()
    {
        return $this->hasOne(AccBusiness::className(), ['business_id' => 'business_id']);
    }
}
