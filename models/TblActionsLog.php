<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_actions_log".
 *
 * @property int $id
 * @property string $index_no
 * @property int $student_id
 * @property string $action_summary
 * @property string $action_taken
 * @property string $added_by
 * @property string $added_date
 */
class TblActionsLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_actions_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['index_no', 'action_taken', 'added_by'], 'required'],
            [['student_id'], 'integer'],
            [['added_date'], 'safe'],
            [['index_no'], 'string', 'max' => 50],
            [['action_summary'], 'string', 'max' => 100],
            [['action_taken'], 'string', 'max' => 255],
            [['added_by'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'index_no' => 'Index No',
            'student_id' => 'Student ID',
            'action_summary' => 'Action Summary',
            'action_taken' => 'Action Taken',
            'added_by' => 'Added By',
            'added_date' => 'Added Date',
        ];
    }
}
