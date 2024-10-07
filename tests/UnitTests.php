<?php

namespace tests;

use DataModels\BankAccount;
use DataModels\Customer;
use DataModels\LimitedBankAccount;
use Helpers\ConsoleAndLogWriter;
use PHPUnit\Framework\TestCase;
use Helpers\ConsoleWriter;

class UnitTests extends TestCase
{
    public function testBankAccountAddMoney()
    {
        $consoleWriter = new ConsoleWriter();
        $bankAccount = new BankAccount($consoleWriter, 'jojo');
        $bankAccount->AddMoney(100);
        $this->assertEquals(100, $bankAccount->currentBalance);
    }

    public function testBankAccountSubtractMoney()
    {
        $consoleWriter = new ConsoleWriter();
        $bankAccount = new BankAccount($consoleWriter, 'jojo', 200);
        $bankAccount->SubtractMoney(100);
        $this->assertEquals(100, $bankAccount->currentBalance);
    }

    public function testBankAccountSubtractMoneyBelowZero()
    {
        $consoleWriter = new ConsoleWriter();
        $bankAccount = new BankAccount($consoleWriter, 'jojo');
        $bankAccount->SubtractMoney(100);
        $this->assertEquals(0, $bankAccount->currentBalance);
    }

    public function testSetAccountNameTooShort()
    {
        $consoleWriter = new ConsoleWriter();
        $bankAccount = new BankAccount($consoleWriter, 'jojo');
        try {
            $bankAccount->SetAccountName('jo');
            $this->assertEquals('jo', $bankAccount->accountName);
            $this->fail('Exception should have been thrown');
        } catch (\Exception $e) {
            $this->assertStringContainsString('Account name is too short', $e->getMessage());
        }
    }

    public function testCustomerCopyBankAccount()
    {
        $consoleWriter = new ConsoleWriter();
        $customer = new Customer($consoleWriter, 'jojo', 100);
        $customer->CopyBankAccount('koko', 'jojo');
        $this->assertEquals($customer->listOfBankAccounts['koko']->currentBalance,
            $customer->listOfBankAccounts['jojo']->currentBalance);
        $customer->listOfBankAccounts['koko']->AddMoney(100);
        $this->assertEquals(100, $customer->listOfBankAccounts['jojo']->currentBalance);
    }

    public function testLimitedBankAccountSubtractMoney()
    {
        $consoleWriter = new ConsoleWriter();
        $limitedBankAccount = new LimitedBankAccount($consoleWriter, 'jojo', 0, -100);
        $limitedBankAccount->SubtractMoney(100);
        $this->assertEquals(-100, $limitedBankAccount->currentBalance);
        try {
            $limitedBankAccount->SubtractMoney(100);
            $this->assertEquals(-200, $limitedBankAccount->currentBalance);
            $this->fail('Exception should have been thrown');
        } catch (\Exception $e) {
            $this->assertEquals(-100, $limitedBankAccount->currentBalance);
        }
    }

    public function testLogFile(){
        $consoleAndLogWriter = new ConsoleAndLogWriter();
        $customer = new Customer($consoleAndLogWriter, 'jojo',0,true);
        $customer->listOfBankAccounts['jojo']->AddMoney(100);
        $customer->PrintHistory();
        $this->assertStringContainsString
        (date(DATE_RFC2822) . ' A corporation',
            file_get_contents('logs.txt',__DIR__ . "/../logs.txt"));
        $this->assertStringContainsString
        (date(DATE_RFC2822) . ' 100 was added',
            file_get_contents('logs.txt',__DIR__ . "/../logs.txt"));
        $this->assertStringContainsString
        (date(DATE_RFC2822) . ' 0',
            file_get_contents('logs.txt',__DIR__ . "/../logs.txt"));
        $this->assertStringContainsString
        (date(DATE_RFC2822) . ' +100',
            file_get_contents('logs.txt',__DIR__ . "/../logs.txt"));
    }
}