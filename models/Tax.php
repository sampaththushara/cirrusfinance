<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tax".
 *
 * @property int $tax_id
 * @property string $tax_name
 * @property string $short_name
 * @property int $tax_ratio
 * @property double $amount
 * @property string $effective_date
 * @property string $status
 */
class Tax extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tax';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tax_name', 'effective_date', 'status'], 'required'],
            [['tax_ratio'], 'integer'],
            [['amount'], 'number'],
            [['effective_date'], 'safe'],
            [['tax_name'], 'string', 'max' => 100],
            [['short_name', 'status'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tax_id' => 'Tax ID',
            'tax_name' => 'Tax Name',
            'short_name' => 'Short Name',
            'tax_ratio' => 'Tax Ratio',
            'amount' => 'Amount',
            'effective_date' => 'Effective Date',
            'status' => 'Status',
        ];
    }
}
