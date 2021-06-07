<?php


namespace Moovin\Job\Backend\Tests;


use Moovin\Job\Backend\CheckingAccount;
use Moovin\Job\Backend\SavingAccount;

class CashMachineTest extends \PHPUnit_Framework_TestCase
{
    public function testDepositCheckingAccount()
    {
        $checkingAccount = new CheckingAccount(500);
        $checkingAccount->deposit(200);

        $this->assertEquals((float) 700, $checkingAccount->balance());
    }

    public function testDepositSavingAccount()
    {
        $savingAccount = new SavingAccount(800);
        $savingAccount->deposit(200);

        $this->assertEquals(1000, $savingAccount->balance());
    }

    public function testWithDrawCheckingAccountGreaterThanBalance()
    {
        $checkingAccount = new CheckingAccount(500);

        $this->expectException(\Exception::class);

        $checkingAccount->withdraw(600);
    }

    public function testWithDrawSavingAccountGreaterThanBalance()
    {
        $savingAccount = new SavingAccount(800);

        $this->expectException(\Exception::class);

        $savingAccount->withdraw(900);
    }

    public function testWithDrawCheckingAccountGreaterThanLimit()
    {
        $checkingAccount = new CheckingAccount(15000);

        $this->expectException(\Exception::class);

        $checkingAccount->withdraw(601);
    }

    public function testWithDrawSavingAccountGreaterThanLimit()
    {
        $savingAccount = new SavingAccount(15000);

        $this->expectException(\Exception::class);

        $savingAccount->withdraw(1001);
    }

    public function testWithDrawCheckingAccount()
    {
        $checkingAccount = new CheckingAccount(15000);

        $checkingAccount->withdraw(300);

        $this->assertEquals(
            15000 - 302.5,
            $checkingAccount->balance()
        );
    }

    public function testWithDrawSavingAccount()
    {
        $savingAccount = new SavingAccount(15000);

        $savingAccount->withdraw(300);

        $this->assertEquals(
            15000 - 300.8,
            $savingAccount->balance()
        );
    }

    public function testTransferCheckingAccountGreaterThanBalance()
    {
        $checkingAccount = new CheckingAccount(500);

        $this->expectException(\Exception::class);

        $checkingAccount->transfer(
            600,
            new CheckingAccount(1000)
        );
    }

    public function testTransferSavingAccountGreaterThanBalance()
    {
        $savingAccount = new SavingAccount(800);

        $this->expectException(\Exception::class);

        $savingAccount->transfer(
            900,
            new SavingAccount(1000)
        );
    }

    public function testTransferCheckingAccount()
    {
        $checkingAccount = new CheckingAccount(500);
        $recipientAccount = new CheckingAccount(1000);

        $checkingAccount->transfer(
            300,
            $recipientAccount
        );

        $this->assertEquals(200, $checkingAccount->balance());
        $this->assertEquals(1300, $recipientAccount->balance());
    }

    public function testTransferSavingAccount()
    {
        $savingAccount = new SavingAccount(800);
        $recipientAccount = new SavingAccount(1000);

        $savingAccount->transfer(
            500,
            $recipientAccount
        );

        $this->assertEquals(300, $savingAccount->balance());
        $this->assertEquals(1500, $recipientAccount->balance());
    }
}