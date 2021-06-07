<?php

require_once __DIR__ . '/vendor/autoload.php';

$checkingAccount = new \Moovin\Job\Backend\CheckingAccount(1500);
$savingAccount = new \Moovin\Job\Backend\SavingAccount(2500);

try {
    $checkingAccount->transfer(150, $savingAccount);

    print_r($checkingAccount);
    print_r($savingAccount);
} catch (Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
}