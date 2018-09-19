<?php
namespace frontend\helpers;


class BankApiHelper
{

    public function tryToSendMoney($account, $amount)
    {
        sleep(2);
        return (rand(1, 10) % 2) === 0;
    }

}