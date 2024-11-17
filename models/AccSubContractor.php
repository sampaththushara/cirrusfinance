<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acc_sub_contractor".
 *
 * @property int $Sub_Contractor_Id
 * @property int $Sub_Contractor_Code
 * @property string $Sub_Contractor_Name
 * @property string $Sub_Contractor_Address
 * @property string $Land_Phone_No
 * @property string $Mobile
 * @property string $Fax
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 * @property int $SubCon_Type
 * @property int $NBT
 * @property int $Is_VAT_Registered
 * @property string $Registation_No
 * @property int $VAT_For_Transport
 * @property string $Attn_Person
 */
class AccSubContractor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acc_sub_contractor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Sub_Contractor_Code', 'Sub_Contractor_Name', 'Sub_Contractor_Address', 'add_by', 'add_date', 'edit_by', 'edit_date', 'SubCon_Type', 'Attn_Person'], 'required'],
            [['Sub_Contractor_Code', 'SubCon_Type', 'NBT', 'Is_VAT_Registered', 'VAT_For_Transport'], 'integer'],
            [['add_date', 'edit_date'], 'safe'],
            [['Sub_Contractor_Name', 'Attn_Person'], 'string', 'max' => 100],
            [['Sub_Contractor_Address'], 'string', 'max' => 200],
            [['Land_Phone_No', 'Mobile', 'Fax'], 'string', 'max' => 12],
            [['add_by', 'edit_by', 'Registation_No'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Sub_Contractor_Id' => 'Sub Contractor ID',
            'Sub_Contractor_Code' => 'Sub Contractor Code',
            'Sub_Contractor_Name' => 'Sub Contractor Name',
            'Sub_Contractor_Address' => 'Sub Contractor Address',
            'Land_Phone_No' => 'Land Phone No',
            'Mobile' => 'Mobile',
            'Fax' => 'Fax',
            'add_by' => 'Add By',
            'add_date' => 'Add Date',
            'edit_by' => 'Edit By',
            'edit_date' => 'Edit Date',
            'SubCon_Type' => 'Sub Con Type',
            'NBT' => 'Nbt',
            'Is_VAT_Registered' => 'Is Vat Registered',
            'Registation_No' => 'Registation No',
            'VAT_For_Transport' => 'Vat For Transport',
            'Attn_Person' => 'Attn Person',
        ];
    }
}
