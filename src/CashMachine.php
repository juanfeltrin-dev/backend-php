<?php


namespace Moovin\Job\Backend;


class CashMachine
{
    /**
     * @param AccountInterface $account
     * @param float $amount
     */
    public function deposit(AccountInterface $account, float $amount)
    {
        $account->deposit($amount);
    }

    /**
     * @param AccountInterface $account
     * @param float $amount
     */
    public function withdraw(AccountInterface $account, float $amount)
    {
        $account->withdraw($amount);
    }

    /**
     * @param AccountInterface $senderAccount
     * @param AccountInterface $recipientAccount
     * @param float $amount
     */
    public function transfer(
        AccountInterface $senderAccount,
        AccountInterface $recipientAccount,
        float $amount
    ) {
        $senderAccount->transfer($amount, $recipientAccount);
    }
}