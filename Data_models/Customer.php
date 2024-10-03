<?php

namespace DataModels;

use Helpers\CustomerType;
use Helpers\IBankWriter;

class Customer
{
    private string $name;
    public array $listOfBankAccounts = [];
    public CustomerType $type;

    public IBankWriter $console;

    public function __construct(
        IBankWriter $console,
        string      $name,
        float       $currentBalance = 0,
        bool        $is_company = false,
        bool        $is_limited = false,
        float       $negativeLimit = 0,
    )
    {
        $this->console = $console;
        $this->name = $name;
        $this->AddBankAccount($name, $currentBalance, $is_limited, $negativeLimit);
        $is_company
            ? $this->type = CustomerType::COMPANY
            : $this->type = CustomerType::PERSON;
    }

    public function AddBankAccount(string $name,
                                   float  $currentBalance,
                                   bool   $is_limited = false,
                                   float  $negativeLimit = 0,
    ): void
    {
        !$is_limited
            ? $this->listOfBankAccounts[$name] = new BankAccount($this->console, $name, $currentBalance)
            : $this->listOfBankAccounts[$name] = new LimitedBankAccount($this->console, $name, $currentBalance, $negativeLimit);
    }

    public function CopyBankAccount(string $nameCopyTo,
                                    string $nameCopyFrom,
    ): void
    {
        $this->listOfBankAccounts[$nameCopyTo] = clone $this->listOfBankAccounts[$nameCopyFrom];
    }

    public function GetTotalBalance(string $name)
    {
        return $this->listOfBankAccounts[$name]->currentBalance;
    }

    public function PrintHistory(): void
    {
        foreach ($this->listOfBankAccounts as $bankAccount) {
            match ($this->type) {
                CustomerType::PERSON =>
                $this->console->Write("A person $bankAccount->accountName:\n"),
                CustomerType::COMPANY =>
                $this->console->Write("A corporation $bankAccount->accountName:\n"),
            };
            $bankAccount->PrintHistory();
        }
    }

    public function PrintStatistics(): void
    {
        foreach ($this->listOfBankAccounts as $bankAccount) {
            $this->console->Write("$bankAccount->accountName:\n");
            $bankAccount->PrintStatistics();
        }
    }

    public function UserInputFromConsole(string $lastUsedAccount): void
    {
        do {
            try {
                $decimalNum = readline
                ('Enter a decimal number amount to add or subtract from your bank account(enter 0 to exit):');
                $this->HandleNumericUserInput($lastUsedAccount, $decimalNum);
            } catch (\Exception $e) {
                $this->console->Write($e->getMessage() . "\n");
                $decimalNum = 0;
                $this->UserInputFromConsole($lastUsedAccount);
            }
        } while ($decimalNum != 0);
    }

    private function HandleNumericUserInput(string $lastUsedAccount, $decimalNum): void
    {
        if (is_numeric($decimalNum)) {
            if ($decimalNum > 0) {
                $this->AddWhenNumberPositive($lastUsedAccount, $decimalNum);
            } else if ($decimalNum < 0) {
                $this->SubtractWhenNumberNegative($lastUsedAccount, $decimalNum);
            }
        } else {
            throw new \Exception("Value entered is not a number. Try again");
        }
    }

    private function AddWhenNumberPositive(string $lastUsedAccount, $decimalNum): void
    {
        $this->listOfBankAccounts[$lastUsedAccount]->AddMoney($decimalNum);
    }

    private function SubtractWhenNumberNegative(string $lastUsedAccount, $decimalNum): void
    {
        $decimalNum = -$decimalNum;
        try {
            $this->listOfBankAccounts[$lastUsedAccount]->SubtractMoney($decimalNum);
        } catch (\Exception $e) {
            $this->console->Write($e->getMessage() . "$decimalNum was not subtracted from your bank account.\n");
        }
    }
}