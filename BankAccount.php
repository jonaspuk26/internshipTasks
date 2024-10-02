<?php
declare(strict_types=1);
include_once __DIR__ . '/IBankWriter.php';
//namespace BankApp;


class BankAccount implements IBankWriter
{
    public string $accountName;
    public float $currentBalance = 0;
    public array $listOfOperations = [];
    public function Write($text): void{
        print $text;
    }

    public function __construct(string $accountName,
                                float  $currentBalance = 0,
    )
    {
        try {
            $this->setAccountName($accountName);
        } catch (Exception $e) {
            $this->Write("Error: " . $e->getMessage() . "\n");
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
            $this->Write($operation . "\n");
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

        $this->Write("Number of operations: " . $opCount['addition'] + $opCount['subtraction'] . "\n");
        if ($opCount['subtraction'] == 0) {
            $this->Write("There were no subtraction operations on this account.\n");
        } else {
            $avgSubtracted = $totalSubtracted / $opCount['subtraction'];
            $this->Write("Number of subtractions: " . $opCount['subtraction'] . "\n");
            $this->Write("Average subtraction amount: " . $avgSubtracted . "\n");
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