<?php

namespace common\models\db;

use Yii;

/**
 * This is the model class for table "{{%loyalty_card}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $balance
 */
class LoyaltyCard extends \yii\db\ActiveRecord
{
    const STARTED_BALANCE = 5;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loyalty_card}}';
    }

    /**
     * @param User $user
     * @return self
     */
    public static function openNewCardToUser($user)
    {
        $model = new self;
        $model->user_id = $user->primaryKey;
        $model->balance = self::STARTED_BALANCE;
        $model->save(false);

        return $model;
    }

    public static function updateUserCardByPrize($prize)
    {
        $card = self::findOne(['user_id' => $prize->user_id]);
        if (!$card)
            $card = self::openNewCardToUser($prize->user);

        $card->balance += $prize->prize_value;
        $card->save(false);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'balance'], 'required'],
            [['user_id', 'balance'], 'integer'],
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
