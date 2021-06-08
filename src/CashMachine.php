<?php


namespace Moovin\Job\Backend;


use Exception;

class CashMachine
{
    private const AMOUNT_CONDITION_GREATER_THAN = 1.00;

    /**
     * @param AccountInterface $account
     * @param float $amount
     * @throws Exception
     */
    public function deposit(AccountInterface $account, float $amount)
    {
        $this->validateIfAmountGreaterThanZero($amount);

        $account->deposit($amount);
    }

    /**
     * @param AccountInterface $account
     * @param float $amount
     * @throws Exception
     */
    public function withdraw(AccountInterface $account, float $amount)
    {
        $this->validateIfAmountGreaterThanZero($amount);

        $account->withdraw($amount);
    }

    /**
     * @param AccountInterface $senderAccount
     * @param AccountInterface $recipientAccount
     * @param float $amount
     * @throws Exception
     */
    public function transfer(
        AccountInterface $senderAccount,
        AccountInterface $recipientAccount,
        float $amount
    ) {
        $this->validateIfAmountGreaterThanZero($amount);

        $senderAccount->transfer($amount, $recipientAccount);
    }

    /**
     * @param float $amount
     * @throws Exception
     */
    private function validateIfAmountGreaterThanZero(float $amount)
    {
        if ($amount < self::AMOUNT_CONDITION_GREATER_THAN) {
            throw new Exception("Valor não pode ser menor que 1.");
        }
    }
}