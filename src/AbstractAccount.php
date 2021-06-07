<?php


namespace Moovin\Job\Backend;


use Exception;

abstract class AbstractAccount
{
    /**
     * @var float
     */
    protected $balance;

    /**
     * @param float $amount
     * @param float $withDrawLimit
     * @throws Exception
     */
    protected function validateAmount($amount, float $withDrawLimit)
    {
        $this->validateWithDrawLimit($amount, $withDrawLimit);
        $this->validateBalance($amount);
    }

    /**
     * @param float $amount
     * @param float $withDrawLimit
     * @throws Exception
     */
    protected function validateWithDrawLimit(float $amount, float $withDrawLimit)
    {
        if ($amount > $withDrawLimit) {
            throw new Exception(
                "O valor excedeu o limite de saque."
            );
        }
    }

    /**
     * @param float $amount
     * @throws Exception
     */
    protected function validateBalance(float $amount)
    {
        if ($amount > $this->balance) {
            throw new Exception("Saldo insuficiente.");
        }
    }

}