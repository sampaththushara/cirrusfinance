<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "expense_master".
 *
 * @property int $exp_id
 * @property string $expense_category
 * @property int $expense_status
 */
class ExpenseMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'expense_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['expense_category'], 'required'],
            [['expense_status'], 'integer'],
            [['expense_category'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'exp_id' => 'Exp ID',
            'expense_category' => 'Expense Category',
            'expense_status' => 'Expense Status',
        ];
    }
}
