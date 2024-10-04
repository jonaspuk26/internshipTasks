<?php

namespace tests;

use DataModels\BankAccount;
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
        try{
            $bankAccount->SetAccountName('jo');
            $this->assertEquals('jo', $bankAccount->accountName);
            $this->fail('Exception should have been thrown');
        } catch(\Exception $e) {
            $this->assertStringContainsString('Account name is too short', $e->getMessage());
        }
    }
}