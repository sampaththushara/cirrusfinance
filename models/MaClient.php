<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ma_client".
 *
 * @property int $Client_Code
 * @property int $Client_Id
 * @property string $Client_Name
 * @property string $Official_Contact_Dtl
 * @property string $Project_Contact_Dtl
 * @property string $Contact_Person_Name
 * @property string $Contact_Person_Email
 * @property string $Contact_Person_Phone
 * @property string $Contact_Person_Mobile
 * @property string $Added_By
 * @property string $Added_Date
 * @property string $Edited_By
 * @property string $Edited_Date
 * @property string $Client_Address
 * @property string $Vat_No
 */
class MaClient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ma_client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Client_Id'], 'integer'],
            [['Client_Name', 'Added_By'], 'required'],
            [['Added_Date', 'Edited_Date'], 'safe'],
            [['Client_Name', 'Official_Contact_Dtl', 'Project_Contact_Dtl', 'Contact_Person_Name', 'Contact_Person_Email'], 'string', 'max' => 100],
            [['Contact_Person_Phone', 'Contact_Person_Mobile'], 'string', 'max' => 15],
            [['Added_By', 'Edited_By'], 'string', 'max' => 50],
            [['Client_Address'], 'string', 'max' => 1024],
            [['Vat_No'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Client_Code' => 'Client Code',
            'Client_Id' => 'Client ID',
            'Client_Name' => 'Client Name',
            'Official_Contact_Dtl' => 'Official Contact Dtl',
            'Project_Contact_Dtl' => 'Project Contact Dtl',
            'Contact_Person_Name' => 'Contact Person Name',
            'Contact_Person_Email' => 'Contact Person Email',
            'Contact_Person_Phone' => 'Contact Person Phone',
            'Contact_Person_Mobile' => 'Contact Person Mobile',
            'Added_By' => 'Added By',
            'Added_Date' => 'Added Date',
            'Edited_By' => 'Edited By',
            'Edited_Date' => 'Edited Date',
            'Client_Address' => 'Client Address',
            'Vat_No' => 'Vat No',
        ];
    }
}
