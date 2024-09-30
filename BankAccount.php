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
    public function PrintStatistics(): void
    {
        $count = 0;
        $subtractionCount = 0;
        $totalSubtracted = 0;
        foreach($this->listOfOperations as $operation){
            if(is_string($operation)){
                $count++;
            }
            if(is_string($operation) && str_contains($operation, "-"))
            {
                $subtractionCount++;
                $totalSubtracted += floatval($operation);
            }
        }

        printf("Number of operations: " . $count . "\n");

        if ($subtractionCount == 0){
            printf("There were no subtraction operations on this account.\n");
        } else {
            $avgSubtracted = $totalSubtracted / $subtractionCount;
            printf("Number of subtractions: " . $subtractionCount . "\n");
            printf("Average subtraction amount: " . $avgSubtracted . "\n");
        }
    }
}