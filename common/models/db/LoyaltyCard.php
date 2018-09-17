<?php

namespace common\models\db;

use Yii;

/**
 * This is the model class for table "{{%loyalty_card}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $balance
 */
class LoyaltyCard extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loyalty_card}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'balance'], 'required'],
            [['user_id'], 'integer'],
            [['balance'], 'string', 'max' => 100],
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
            'balance' => Yii::t('app', 'Balance'),
        ];
    }
}
