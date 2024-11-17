<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ca_group".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $ca_groups
 * @property string $code
 * @property int $statement_type_id
 *
 * @property StatementType $statementType
 */
class CaGroup extends \yii\db\ActiveRecord
{
    //use \kartik\tree\models\TreeTrait ;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ca_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'statement_type_id'], 'integer'],
            [['item_name','code'], 'required'],
            [['ca_level','parent_name'], 'safe'],
            [['item_name', 'code'], 'string', 'max' => 50],
            [['statement_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatementType::className(), 'targetAttribute' => ['statement_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'item_name' => 'Name',
            'code' => 'Code',
            'statement_type_id' => 'Statement Type ID',
            'ca_level' => 'Level',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatementType()
    {
        return $this->hasOne(StatementType::className(), ['id' => 'statement_type_id']);
    }
}
