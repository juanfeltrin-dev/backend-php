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
     * @param float $withdrawLimit
     * @throws Exception
     */
    protected function validateAmount($amount, float $withdrawLimit)
    {
        $this->validateWithdrawLimit($amount, $withdrawLimit);
        $this->validateBalance($amount);
    }

    /**
     * @param float $amount
     * @param float $withdrawLimit
     * @throws Exception
     */
    protected function validateWithdrawLimit(float $amount, float $withdrawLimit)
    {
        if ($amount > $withdrawLimit) {
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