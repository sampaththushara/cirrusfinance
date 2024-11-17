<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "statement_type".
 *
 * @property int $id
 * @property string $statement_type
 *
 * @property CaGroup[] $caGroups
 */
class StatementType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statement_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['statement_type'], 'required'],
            [['statement_type'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'statement_type' => 'Statement Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaGroups()
    {
        return $this->hasMany(CaGroup::className(), ['statement_type_id' => 'id']);
    }
}
