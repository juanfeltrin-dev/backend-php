<?php

require_once __DIR__ . '/vendor/autoload.php';

try {
    $cashMachine = new \Moovin\Job\Backend\CashMachine();

    $checkingAccount = new \Moovin\Job\Backend\CheckingAccount(1500);
    $savingAccount = new \Moovin\Job\Backend\SavingAccount(2500);

    $cashMachine->withdraw($checkingAccount, -150);

    print_r($checkingAccount);
    print_r($savingAccount);
} catch (Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
}