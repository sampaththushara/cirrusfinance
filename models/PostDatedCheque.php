<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acc_post_dated_cheque".
 *
 * @property int $id
 * @property string $cheque_no
 * @property string $cheque_date
 * @property string $received_date
 * @property string $customer_name
 * @property string $chq_description
 * @property string $chq_status
 */
class PostDatedCheque extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acc_post_dated_cheque';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cheque_no', 'cheque_date','business_id','chq_amount'], 'required'],  
            [['account_id'], 'integer'],
            [['cheque_date', 'received_date', 'paid_chq_amount'], 'safe'],
            [['cheque_no', 'chq_status'], 'string', 'max' => 20],
            [['customer_name'], 'string', 'max' => 100],
            [['chq_description'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_id' => 'Account ID',
            'cheque_no' => 'Cheque No',
            'cheque_date' => 'Cheque Dated',
            'received_date' => 'Issued Date',
            'customer_name' => 'Payee Name',
            'chq_description' => 'Description',
            'chq_status' => 'Chq Status',
            'business_id' => 'Project',
            'chq_amount' => 'Cheque Amount',
            'paid_chq_amount' => 'Paid Cheque Amount'
        ];
    }
}
