<?php
namespace frontend\controllers;

use common\models\db\Game;
use common\models\db\Gift;
use common\models\db\PrizeReceiver;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class GiftController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    public function actionIndex() {
        $update_prize_result = function ($prize) {
            $returned_result = $prize->attributes;
            if ($prize->prize_type === PrizeReceiver::PRIZE_TYPE_IS_GIFT) {
                $gift = Gift::findOne($prize->prize_value);
                $returned_result['gift'] = $gift->attributes;
            }
            return $returned_result;
        };

        $app = Yii::$app;
        if ($app->request->method === 'POST') {
            $transaction = $app->db->beginTransaction();
            try {
                /** @var Game $game */
                $game = Game::find()->where(['is_active' => true])->orderBy(['id' => SORT_DESC])->one();
                $new_prize = PrizeReceiver::generateAvailablePrize($app->user->identity, $game);

                $transaction->commit();
                return $update_prize_result($new_prize);
            } catch (Exception $exception) {
                $transaction->rollBack();
                return null;
            }
        }

        /** @var PrizeReceiver $last_prize */
        $last_prize = PrizeReceiver::find()
            ->where([
                'prize_status' => PrizeReceiver::STATUS_IS_OFFER,
                'user_id' => $app->user->id,
            ])
            ->one();
        if (!$last_prize)
            return null;

        return $update_prize_result($last_prize);
    }

    public function actionRefuse($id)
    {
        /** @var PrizeReceiver $model */
        if (!($model = PrizeReceiver::findOne($id)))
            return null;

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->refusePrizeAndUpdateGameBalance();
            $transaction->commit();
            return $id;
        } catch (Exception $exception) {
            $transaction->rollBack();
            return null;
        }
    }

    public function actionAccept($id)
    {
        /** @var PrizeReceiver $model */
        if (!($model = PrizeReceiver::findOne($id)))
            return null;

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->acceptPrize();
            $transaction->commit();
            return $id;
        } catch (Exception $exception) {
            $transaction->rollBack();
            return null;
        }
    }

    public function actionConvert($id)
    {
        /** @var PrizeReceiver $model */
        if (!($model = PrizeReceiver::findOne(['id' => $id, 'prize_type' => PrizeReceiver::PRIZE_TYPE_IS_MONEY])))
            return null;

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->convertMoneyToBonus();
            $transaction->commit();
            return $id;
        } catch (Exception $exception) {
            $transaction->rollBack();
            var_dump($exception->getMessage()); exit;
            return null;
        }
    }
}
