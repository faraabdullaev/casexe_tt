<?php

namespace common\models\db;

use frontend\helpers\BankApiHelper;
use frontend\helpers\PrizeGeneratorHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%prize_receiver}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $game_id
 * @property int $prize_type
 * @property int $prize_value
 * @property int $prize_status
 * @property string $created_date
 * @property string $updated_date
 * @property Game $game
 * @property User $user
 * @property Gift $gift
 */
class PrizeReceiver extends \yii\db\ActiveRecord
{
    const PRIZE_TYPE_IS_BONUS = 0;
    const PRIZE_TYPE_IS_GIFT = 1;
    const PRIZE_TYPE_IS_MONEY = 2;

    const STATUS_IS_OFFER = 0;
    const STATUS_IS_ACCEPTED = 1;
    const STATUS_IS_SENT = 2;
    const STATUS_IS_CONVERTED = 3;
    const STATUS_IS_PROCESSED = 4;
    const STATUS_IS_DECLINED = 9;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%prize_receiver}}';
    }

    /**
     * @param User $user
     * @param Game $game
     * @return PrizeReceiver
     */
    public static function generateAvailablePrize($user, $game)
    {
        $helper = new PrizeGeneratorHelper;

        $model = new self;
        $model->user_id = $user->id;
        $model->game_id = $game->id;
        $model->prize_status = self::STATUS_IS_OFFER;
        $model->prize_type = $helper->getPrizeType($game);
        $model->prize_value = $helper->getPrizeValue($game, $model->prize_type);

        if ($model->save(false))
            $helper->recalculateGameBalance($game, $model->prize_type, $model->prize_value);

        return $model;
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_date',
                'updatedAtAttribute' => 'updated_date',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'prize_type', 'game_id', 'prize_value'], 'required'],
            [['user_id', 'prize_type', 'prize_value', 'prize_status', 'game_id'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
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
            'game_id' => Yii::t('app', 'Game ID'),
            'prize_type' => Yii::t('app', 'Prize Type'),
            'prize_value' => Yii::t('app', 'Prize Value'),
            'prize_status' => Yii::t('app', 'Prize Status'),
            'created_date' => Yii::t('app', 'Created Date'),
            'updated_date' => Yii::t('app', 'Updated Date'),
        ];
    }

    public function typeLabels()
    {
        return [
            self::PRIZE_TYPE_IS_BONUS => Yii::t('app', 'Bonus'),
            self::PRIZE_TYPE_IS_MONEY => Yii::t('app', 'Money'),
            self::PRIZE_TYPE_IS_GIFT => Yii::t('app', 'Gift'),
        ];
    }

    public function statusLabels()
    {
        return [
            self::STATUS_IS_OFFER => Yii::t('app', 'Offer'),
            self::STATUS_IS_ACCEPTED => Yii::t('app', 'Accepted'),
            self::STATUS_IS_SENT => Yii::t('app', 'Sent'),
            self::STATUS_IS_CONVERTED => Yii::t('app', 'Converted'),
            self::STATUS_IS_DECLINED => Yii::t('app', 'Declined'),
            self::STATUS_IS_PROCESSED => Yii::t('app', 'Processed'),
        ];
    }

    public function getGift()
    {
        return $this->hasOne(Gift::class, ['id' => 'prize_value']);
    }

    public function getGame()
    {
        return $this->hasOne(Game::class, ['id' => 'game_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function refusePrizeAndUpdateGameBalance()
    {
        $this->prize_status = self::STATUS_IS_DECLINED;

        if ($this->prize_type === self::PRIZE_TYPE_IS_GIFT) {
            $gift = Gift::findOne($this->prize_value);
            $gift->count += 1;
            $gift->save(false);
        } elseif ($this->prize_type === self::PRIZE_TYPE_IS_MONEY) {
            $this->game->updateMoneyBalanceAndSave($this->prize_value);
        }

        $this->save(false);
    }

    public function acceptPrize()
    {
        $this->prize_status = self::STATUS_IS_ACCEPTED;

        if ($this->prize_type === self::PRIZE_TYPE_IS_BONUS) {
            LoyaltyCard::updateUserCardByPrize($this);
            $this->prize_status = self::STATUS_IS_PROCESSED;
        }

        if ($this->prize_type === self::PRIZE_TYPE_IS_MONEY) {
            $helper = new BankApiHelper();
            if ($helper->tryToSendMoney($this->user->bank_account, $this->prize_value))
                $this->prize_status = self::STATUS_IS_PROCESSED;
        }

        $this->save();
    }

    public function convertMoneyToBonus()
    {
        $card = LoyaltyCard::findOrCreateUserCard($this->user);
        $card->balance  += floor($this->prize_value * $this->game->conversion_rate);
        $card->save();

        $this->game->updateMoneyBalanceAndSave($this->prize_value);

        $this->prize_status = self::STATUS_IS_PROCESSED;
        $this->save();
    }
}
