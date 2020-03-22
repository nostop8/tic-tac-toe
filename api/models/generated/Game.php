<?php

namespace app\models\generated;

use Yii;

/**
 * This is the model class for table "game".
 *
 * @property string $id
 * @property string $board
 * @property string $status
 */
class Game extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'game';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'board', 'status'], 'required'],
            [['status'], 'string'],
            [['id'], 'string', 'max' => 36],
            [['board'], 'string', 'max' => 11],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'board' => Yii::t('app', 'Board'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
