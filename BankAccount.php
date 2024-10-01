<?php
declare(strict_types=1);

//namespace BankApp;


class BankAccount
{
    public string $accountName;
    public float $currentBalance = 0;
    private array $listOfOperations = [];

    public function __construct(string $accountName,
                                float  $currentBalance = 0,
    )
    {
        try {
            $this->setAccountName($accountName);
        } catch (Exception $e) {
            print "Error: " . $e->getMessage() . "\n";
        }
        $this->currentBalance = $currentBalance;
        $this->listOfOperations[] = $currentBalance;
    }

    public function setAccountName(string $accountName): void
    {
        if (strlen($accountName) >= 3) {
            $this->accountName = $accountName;
        } else {
            throw new Exception("Account name is too short.");
        }
    }

    public function AddMoney(float $amount): void
    {
        $this->currentBalance += $amount;
        $this->listOfOperations[] = "+$amount";
    }

    public function SubtractMoney(float $amount): void
    {
        if ($this->currentBalance < $amount) {
            throw new Exception
            ("Overdraw: current balance is $this->currentBalance, you tried to subtract $amount.\n");
        } else {
            $this->currentBalance -= $amount;
            $this->listOfOperations[] = "-$amount";
        }
    }

    public function PrintHistory(): void
    {
        foreach ($this->listOfOperations as $operation) {
            printf($operation . "\n");
        }
    }

    public function PrintStatistics(): void
    {
        $totalSubtracted = 0;
        foreach ($this->listOfOperations as $operation) {
            if (is_string($operation) && str_contains($operation, "-")) {
                $totalSubtracted += floatval($operation);
            }
        }
        $opCount = $this->GetOperationsCounts();

        printf("Number of operations: " . $opCount['addition'] + $opCount['subtraction'] . "\n");
        if ($opCount['subtraction'] == 0) {
            printf("There were no subtraction operations on this account.\n");
        } else {
            $avgSubtracted = $totalSubtracted / $opCount['subtraction'];
            printf("Number of subtractions: " . $opCount['subtraction'] . "\n");
            printf("Average subtraction amount: " . $avgSubtracted . "\n");
        }
    }

    public function GetOperationsCounts(): array
    {
        $additionCount = 0;
        $subtractionCount = 0;
        $operationsCounts = [];

        foreach ($this->listOfOperations as $operation) {
            if (is_string($operation) && str_contains($operation, "+")) {
                $additionCount++;
            }
            if (is_string($operation) && str_contains($operation, "-")) {
                $subtractionCount++;
            }
        }
        $operationsCounts['addition'] = $additionCount;
        $operationsCounts['subtraction'] = $subtractionCount;
        return $operationsCounts;
    }
}