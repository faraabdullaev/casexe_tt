<?php
/**
 * Created by PhpStorm.
 * User: Farrukh
 * Date: 09-12-2016
 * Time: 12:29
 */

namespace console\controllers;


use common\helpers\BankApiHelper;
use common\models\db\PrizeReceiver;
use yii\console\Controller;

/**
 *
 * Class MoneyTransferController
 * @package console\controllers
 */
class MoneyTransferController extends Controller
{
    /**
     * Make transactions by N-portion
     * @param int $portion_size
     */
    public function actionSendByPortion($portion_size = 30)
    {
        $portion_size = (int) $portion_size;
        $this->logToConsole("Process start");

        /** @var PrizeReceiver[] $models */
        $models = PrizeReceiver::find()
            ->where([
                'prize_type' => PrizeReceiver::PRIZE_TYPE_IS_MONEY,
                'prize_status' => PrizeReceiver::STATUS_IS_ACCEPTED])
            ->limit($portion_size)
            ->all();
        $this->logToConsole(count($models) . " object found");


        $this->logToConsole("API initializing");
        $errorLog = [];
        $writeToErrorLog = function ($error) use (&$errorLog) {
            $errorLog[] = $error;
        };
        $helper = new BankApiHelper();

        $this->logToConsole("Start sending");
        foreach ($models as $model) {
            if (!$model->user->bank_account) {
                $writeToErrorLog("User({$model->user_id}): {$model->user->username} has no bank account. ModelID {$model->id}");
                continue;
            }

            if (!$helper->tryToSendMoney($model->user->bank_account, $model->prize_value)) {
                $writeToErrorLog("Can not make transaction. ModelID {$model->id}");
                continue;
            }

            $model->prize_status = PrizeReceiver::STATUS_IS_PROCESSED;
            if (!$model->save()) {
                $writeToErrorLog("Can not save model. ModelID {$model->id}");
            }
        }

        $errorCount = count($errorLog);
        if ($errorCount > 0) {
            $this->logToConsole("$errorCount models failed");
            $this->writeLogFile($errorLog);
            $this->logToConsole("Report file ready");
        }

        $this->logToConsole("Process finished");
    }

    private function logToConsole($text)
    {
        echo $text . PHP_EOL;
    }

    private function writeLogFile($errorLog)
    {
        // TODO:: implement report to file
    }
}