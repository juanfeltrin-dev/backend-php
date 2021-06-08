<?php


namespace Moovin\Job\Backend;


use Exception;

class SavingAccount extends AbstractAccount implements AccountInterface
{
    private const FEE_PER_WITHDRAW = 0.8;

    private const WITHDRAW_LIMIT = 1000.0;

    /**
     * SavingAccount constructor.
     * @param float $balance
     */
    public function __construct(float $balance)
    {
        $this->balance = $balance;
    }

    /**
     * @return float
     */
    public function balance(): float
    {
        return $this->balance;
    }

    /**
     * @param float $amount
     */
    public function deposit(float $amount)
    {
        $this->balance += $amount;
    }

    /**
     * @param float $amount
     * @throws Exception
     */
    public function withdraw(float $amount)
    {
        $amountWithFee = $amount + self::FEE_PER_WITHDRAW;

        $this->validateAmount($amountWithFee, self::WITHDRAW_LIMIT);

        $this->balance -= $amountWithFee;
    }

    /**
     * @param float $amount
     * @param AccountInterface $account
     * @throws Exception
     */
    public function transfer(float $amount, AccountInterface $account)
    {
        $this->validateBalance($amount);

        $this->balance -= $amount;

        $account->deposit($amount);
    }
}