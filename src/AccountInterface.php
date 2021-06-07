<?php


namespace Moovin\Job\Backend;


interface AccountInterface
{
    public function balance();
    
    public function deposit(float $amount);

    public function withdraw(float $amount);

    public function transfer(float $amount, AccountInterface $account);
}