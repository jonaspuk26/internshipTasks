<?php
include __DIR__ . '/BankAccount.php';
#[\AllowDynamicProperties]

class Customer extends BankAccount {
    private string $name;
    public array $listOfBankAccounts = [];
    public function __construct(string $name, float $currentBalance = 0)
    {
        parent::__construct($name, $currentBalance);
        $this->name = $name;
        $this->AddBankAccount($name, $currentBalance);
    }
    public function AddBankAccount(string $name, float $currentBalance): void
    {
        $this->listOfBankAccounts[$name] = new BankAccount($name, $currentBalance);
    }

    public function CopyBankAccount(string $nameCopyTo, string $nameCopyFrom): void
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
            printf("$bankAccount->accountName:\n");
            $bankAccount->PrintHistory();
        }
    }
    public function PrintStatistics(): void{
        foreach ($this->listOfBankAccounts as $bankAccount) {
            printf("$bankAccount->accountName:\n");
            $bankAccount->PrintStatistics();
        }
    }
}