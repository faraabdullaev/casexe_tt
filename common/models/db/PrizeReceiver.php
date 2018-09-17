<?php

namespace common\models\db;

use Yii;

/**
 * This is the model class for table "{{%prize_receiver}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $prize_type
 * @property int $prize_value
 * @property int $prize_status
 * @property string $date
 */
class PrizeReceiver extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%prize_receiver}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'prize_type'], 'required'],
            [['user_id', 'prize_type', 'prize_value', 'prize_status'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'prize_type' => Yii::t('app', 'Prize Type'),
            'prize_value' => Yii::t('app', 'Prize Value'),
            'prize_status' => Yii::t('app', 'Prize Status'),
            'date' => Yii::t('app', 'Date'),
        ];
    }
}
