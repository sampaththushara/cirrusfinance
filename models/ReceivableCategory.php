<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "receivable_category".
 *
 * @property int $Receivable_Cat_ID
 * @property string $Receivable_Category
 * @property string $Cat_Status
 */
class ReceivableCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receivable_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Receivable_Category'], 'required'],
            [['Receivable_Category'], 'string', 'max' => 100],
            [['Cat_Status'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Receivable_Cat_ID' => 'Receivable Cat ID',
            'Receivable_Category' => 'Receivable Category',
            'Cat_Status' => 'Cat Status',
        ];
    }
}
