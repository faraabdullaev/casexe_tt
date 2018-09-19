<?php
/**
 * Created by PhpStorm.
 * User: VX15
 * Date: 18.09.2018
 * Time: 21:15
 */

namespace frontend\helpers;


use common\models\db\Game;
use common\models\db\Gift;
use common\models\db\PrizeReceiver;
use yii\db\Expression;

class PrizeGeneratorHelper
{
    /**
     * @param Game $game
     * @return int
     */
    public function getPrizeType($game)
    {
        $coefficients_by_types = $this->getCoefficients($game);
        $magic_number = rand(0, $game::MAX_PERCENT - 1);

        if (0 <= $magic_number && $magic_number < $coefficients_by_types[PrizeReceiver::PRIZE_TYPE_IS_MONEY])
            return PrizeReceiver::PRIZE_TYPE_IS_MONEY;

        if ($coefficients_by_types[PrizeReceiver::PRIZE_TYPE_IS_MONEY] < $magic_number
            && $magic_number < $coefficients_by_types[PrizeReceiver::PRIZE_TYPE_IS_GIFT])
            return PrizeReceiver::PRIZE_TYPE_IS_GIFT;

        return PrizeReceiver::PRIZE_TYPE_IS_BONUS;
    }

    /**
     * @param Game $game
     * @param integer $prize_type
     * @return float
     */
    public function getPrizeValue($game, $prize_type)
    {
        if ($prize_type === PrizeReceiver::PRIZE_TYPE_IS_GIFT)
            return $this->getRandomGift($game);

        if ($prize_type === PrizeReceiver::PRIZE_TYPE_IS_MONEY)
            return $this->getRandomFromInterval($game->money_from, $game->money_to);

        return $this->getRandomFromInterval($game->bonus_from, $game->bonus_to);
    }

    /**
     * @param Game $game
     * @param integer $prize_type
     * @param float $prize_value
     */
    public function recalculateGameBalance($game, $prize_type, $prize_value)
    {
        if ($prize_type === PrizeReceiver::PRIZE_TYPE_IS_BONUS)
            return;

        if ($prize_type === PrizeReceiver::PRIZE_TYPE_IS_MONEY) {
            $game->updateMoneyBalanceAndSave(-$prize_value);
            return;
        }

        $gift = Gift::findOne($prize_value);
        $gift->count -= 1;
        $gift->save(false);
    }

    /**
     * @param Game $game
     * @return mixed
     */
    private function getCoefficients($game)
    {
        $coefficients = [
            PrizeReceiver::PRIZE_TYPE_IS_BONUS => $game->bonus_share,
            PrizeReceiver::PRIZE_TYPE_IS_MONEY => -1,
            PrizeReceiver::PRIZE_TYPE_IS_GIFT => -1,
        ];

        $can_give_money = $game->money_balance > $game->money_from && $game->money_share > 0;
        if (!$can_give_money)
            $coefficients[PrizeReceiver::PRIZE_TYPE_IS_BONUS] += $game->money_share;
        else
            $coefficients[PrizeReceiver::PRIZE_TYPE_IS_MONEY] = $game->money_share;

        $can_give_gift = $game->gift_share > 0 && Gift::find()
                                                    ->andWhere(['game_id' => $game->id])
                                                    ->andWhere(['>','count', 0])
                                                    ->exists();
        if (!$can_give_gift)
            $coefficients[PrizeReceiver::PRIZE_TYPE_IS_BONUS] += $game->gift_share;
        else
            $coefficients[PrizeReceiver::PRIZE_TYPE_IS_MONEY] = $game->gift_share;

        return $coefficients;
    }

    /**
     * @param Game $game
     * @return integer
     */
    private function getRandomGift($game)
    {
        $gift = Gift::find()->where(['game_id' => $game->id])->orderBy(new Expression('rand()'))->one();
        return $gift->id;
    }

    /**
     * @param integer $min
     * @param integer $max
     * @return integer
     */
    private function getRandomFromInterval($min, $max)
    {
        return rand($min, $max);
    }

}