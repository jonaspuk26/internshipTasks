<?php
declare(strict_types=1);
#[\AllowDynamicProperties]

class BankAccount{
    public string $accountName;
    public float $currentBalance = 0;
    private array $listOfOperations = [];
    public function __construct(string $accountName, float $currentBalance = 0)
    {
        $this->accountName = $accountName;
        $this->currentBalance = $currentBalance;
        $this->listOfOperations[] = $currentBalance;
    }
    public function AddMoney(float $amount): void
    {
        $this->currentBalance += $amount;
        $this->listOfOperations[] = "+$amount";
    }
    public function SubtractMoney(float $amount): void
    {
        if($this->currentBalance < $amount)
        {
            printf("Overdraw: current balance is $this->currentBalance, you tried to subtract $amount\n");
        } else {
            $this->currentBalance -= $amount;
            $this->listOfOperations[] = "-$amount";
        }
    }
    public function PrintHistory(): void
    {
    foreach($this->listOfOperations as $operation)
    {
        printf($operation . "\n");
    }
    }
}