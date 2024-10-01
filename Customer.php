<?php
include __DIR__ . '/BankAccount.php';
include __DIR__ . '/CustomerType.php';
//namespace BankApp;
//use BankApp\BankAccount as BankAccount;

class Customer extends BankAccount
{
    private string $name;
    public array $listOfBankAccounts = [];
    public CustomerType $type;

    public function __construct(
        string $name,
        float  $currentBalance = 0,
        bool   $is_company = false,
    )
    {
        parent::__construct($name, $currentBalance);
        $this->name = $name;
        $this->AddBankAccount($name, $currentBalance);
        $is_company
            ? $this->type = CustomerType::COMPANY
            : $this->type = CustomerType::PERSON;
    }

    public function AddBankAccount(string $name,
                                   float  $currentBalance,
    ): void
    {
        $this->listOfBankAccounts[$name] = new BankAccount($name, $currentBalance);
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

    public function PrintHistoryCustomer(): void
    {
        foreach ($this->listOfBankAccounts as $bankAccount) {
            match ($this->type) {
                CustomerType::PERSON =>
                printf("A person $bankAccount->accountName:\n"),
                CustomerType::COMPANY =>
                printf("A corporation $bankAccount->accountName:\n"),
            };
            printf("$bankAccount->accountName:\n");
            $bankAccount->PrintHistory();
        }
    }

    public function PrintStatistics(): void
    {
        foreach ($this->listOfBankAccounts as $bankAccount) {
            printf("$bankAccount->accountName:\n");
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
            } catch (Exception $e) {
                print $e->getMessage() . "\n";
                $decimalNum = 0;
                $this->UserInputFromConsole($lastUsedAccount);
            }
        } while ($decimalNum != 0);
    }

    private function HandleNumericUserInput(string $lastUsedAccount, $decimalNum): float
    {
        if (is_numeric($decimalNum)) {
            if ($decimalNum > 0) {
                $this->AddWhenNumberPositive($lastUsedAccount, $decimalNum);
                return $decimalNum;
            } else if ($decimalNum < 0) {
                $this->SubtractWhenNumberNegative($lastUsedAccount, $decimalNum);
                return $decimalNum;
            } else {
                return $decimalNum = 0;
            }
        } else {
            throw new Exception("Value entered is not a number. Try again");
        }
    }

    private function AddWhenNumberPositive(string $lastUsedAccount, $decimalNum): float
    {
        $this->listOfBankAccounts[$lastUsedAccount]->AddMoney($decimalNum);
        print "$decimalNum was added to your bank account.\n";
        return $decimalNum;
    }

    private function SubtractWhenNumberNegative(string $lastUsedAccount, $decimalNum): float
    {
        $decimalNum = -$decimalNum;
        try {
            $this->listOfBankAccounts[$lastUsedAccount]->SubtractMoney($decimalNum);
            print "$decimalNum was subtracted from your bank account.\n";
        } catch (Exception $e) {
            print $e->getMessage() . "$decimalNum was not subtracted from your bank account.\n";
        }
        return $decimalNum;
    }
}