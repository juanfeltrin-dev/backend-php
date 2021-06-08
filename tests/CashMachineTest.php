<?php


namespace Moovin\Job\Backend\Tests;


use Moovin\Job\Backend\CashMachine;
use Moovin\Job\Backend\CheckingAccount;
use Moovin\Job\Backend\SavingAccount;

class CashMachineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CashMachine
     */
    protected $cashMachine;

    protected function setUp()
    {
        $this->cashMachine = new CashMachine();
    }

    public function testDepositCheckingAccount()
    {
        $checkingAccount = new CheckingAccount(500);
        $this->cashMachine->deposit($checkingAccount, 200);

        $this->assertEquals((float) 700, $checkingAccount->balance());
    }

    public function testDepositSavingAccount()
    {
        $savingAccount = new SavingAccount(800);
        $this->cashMachine->deposit($savingAccount, 200);

        $this->assertEquals(1000, $savingAccount->balance());
    }

    public function testWithDrawCheckingAccountGreaterThanBalance()
    {
        $checkingAccount = new CheckingAccount(500);

        $this->expectException(\Exception::class);

        $this->cashMachine->withdraw($checkingAccount, 600);
    }

    public function testWithDrawSavingAccountGreaterThanBalance()
    {
        $savingAccount = new SavingAccount(800);

        $this->expectException(\Exception::class);

        $this->cashMachine->withdraw($savingAccount, 900);
    }

    public function testWithDrawCheckingAccountGreaterThanLimit()
    {
        $checkingAccount = new CheckingAccount(15000);

        $this->expectException(\Exception::class);

        $this->cashMachine->withdraw($checkingAccount, 601);
    }

    public function testWithDrawSavingAccountGreaterThanLimit()
    {
        $savingAccount = new SavingAccount(15000);

        $this->expectException(\Exception::class);

        $this->cashMachine->withdraw($savingAccount, 1001);
    }

    public function testWithDrawCheckingAccount()
    {
        $checkingAccount = new CheckingAccount(15000);

        $this->cashMachine->withdraw($checkingAccount, 300);

        $this->assertEquals(
            15000 - 302.5,
            $checkingAccount->balance()
        );
    }

    public function testWithDrawSavingAccount()
    {
        $savingAccount = new SavingAccount(15000);

        $this->cashMachine->withdraw($savingAccount, 300);

        $this->assertEquals(
            15000 - 300.8,
            $savingAccount->balance()
        );
    }

    public function testTransferCheckingAccountGreaterThanBalance()
    {
        $checkingAccount = new CheckingAccount(500);

        $this->expectException(\Exception::class);

        $this->cashMachine->transfer(
            $checkingAccount,
            new CheckingAccount(1000),
            600
        );
    }

    public function testTransferSavingAccountGreaterThanBalance()
    {
        $savingAccount = new SavingAccount(800);

        $this->expectException(\Exception::class);

        $this->cashMachine->transfer(
            $savingAccount,
            new SavingAccount(1000),
            900
        );
    }

    public function testTransferCheckingAccount()
    {
        $checkingAccount = new CheckingAccount(500);
        $recipientAccount = new CheckingAccount(1000);

        $this->cashMachine->transfer(
            $checkingAccount,
            $recipientAccount,
            300
        );

        $this->assertEquals(200, $checkingAccount->balance());
        $this->assertEquals(1300, $recipientAccount->balance());
    }

    public function testTransferSavingAccount()
    {
        $savingAccount = new SavingAccount(800);
        $recipientAccount = new SavingAccount(1000);

        $this->cashMachine->transfer(
            $savingAccount,
            $recipientAccount,
            500
        );

        $this->assertEquals(300, $savingAccount->balance());
        $this->assertEquals(1500, $recipientAccount->balance());
    }
}