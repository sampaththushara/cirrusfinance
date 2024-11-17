<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payer_master".
 *
 * @property int $payer_id
 * @property string $payer_name
 * @property string $payer_status
 *
 * @property TblReceivable[] $tblReceivables
 */
class PayerMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payer_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payer_name', 'payer_status'], 'required'],
            [['payer_name'], 'string', 'max' => 100],
            [['payer_status'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'payer_id' => 'Payer ID',
            'payer_name' => 'Payer Name',
            'payer_status' => 'Payer Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblReceivables()
    {
        return $this->hasMany(TblReceivable::className(), ['payer_id' => 'payer_id']);
    }
}
