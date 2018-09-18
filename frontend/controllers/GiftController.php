<?php
namespace frontend\controllers;

use common\models\db\Game;
use common\models\db\Gift;
use common\models\db\PrizeReceiver;
use Yii;
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
                'only' => ['index', 'view'],
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
            /** @var Game $game */
            $game = Game::find()->where(['is_active' => true])->orderBy(['id' => SORT_DESC])->one();
            $new_prize = PrizeReceiver::generateAvailablePrize($app->user->identity, $game);

            return $update_prize_result($new_prize);
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

}
