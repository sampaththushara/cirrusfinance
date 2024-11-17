<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payee_master".
 *
 * @property int $payee_id
 * @property string $payee_name
 * @property string $payee_status
 *
 * @property TblPayable[] $tblPayables
 */
class PayeeMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payee_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payee_name'], 'required'],
            [['payee_name'], 'string', 'max' => 50],
            [['payee_status'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'payee_id' => 'Payee ID',
            'payee_name' => 'Payee Name',
            'payee_status' => 'Payee Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblPayables()
    {
        return $this->hasMany(TblPayable::className(), ['payee_id' => 'payee_id']);
    }
}
