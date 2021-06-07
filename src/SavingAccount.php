<?php


namespace Moovin\Job\Backend;


use Exception;

class SavingAccount extends AbstractAccount implements AccountInterface
{
    private const FEE_PER_WITHDRAW = 0.80;

    private const WITHDRAW_LIMIT = 1000.00;

    /**
     * SavingAccount constructor.
     * @param float $balance
     */
    public function __construct(float $balance)
    {
        $this->balance = $balance;
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
        $this->validateAmount($amount, self::WITHDRAW_LIMIT);

        $this->balance -= $amount + self::FEE_PER_WITHDRAW;
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