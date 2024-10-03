<?php
declare(strict_types=1);

namespace DataModels;

use Helpers\IBankWriter;

class BankAccount
{
    public string $accountName;
    public float $currentBalance = 0;
    public array $listOfOperations = [];

    public IBankWriter $console;

    public function __construct
    (
        IBankWriter $console,
        string      $accountName,
        float       $currentBalance = 0,
    )
    {
        try {
            $this->setAccountName($accountName);
        } catch (\Exception $e) {
            $console->Write("Error: " . $e->getMessage() . "\n");
        }
        $this->console = $console;
        $this->currentBalance = $currentBalance;
        $this->listOfOperations[] = $currentBalance;
    }

    public function setAccountName(string $accountName): void
    {
        if (strlen($accountName) >= 3) {
            $this->accountName = $accountName;
        } else {
            throw new \Exception("Account name is too short.");
        }
    }

    public function AddMoney(float $amount): void
    {
        $this->currentBalance += $amount;
        $this->listOfOperations[] = "+$amount";
        $this->console->Write("$amount was added to your bank account.\n");
    }

    public function SubtractMoney(float $amount): void
    {
        try {
            $this->SubtractMoneyIfEligible($amount);
            $this->console->Write("$amount was subtracted from your bank account.\n");
        } catch (\Exception $e) {
            $this->console->Write($e->getMessage() . "$amount was not subtracted from your bank account.\n");
        }
    }

    public function PrintHistory(): void
    {
        foreach ($this->listOfOperations as $operation) {
            $this->console->Write($operation . "\n");
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

        $this->console->Write("Number of operations: " . $opCount['addition'] + $opCount['subtraction'] . "\n");
        if ($opCount['subtraction'] == 0) {
            $this->console->Write("There were no subtraction operations on this account.\n");
        } else {
            $avgSubtracted = $totalSubtracted / $opCount['subtraction'];
            $this->console->Write("Number of subtractions: " . $opCount['subtraction'] . "\n");
            $this->console->Write("Average subtraction amount: " . $avgSubtracted . "\n");
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

    private function SubtractMoneyIfEligible($amount): void
    {
        if ($this->currentBalance < $amount) {
            throw new \Exception
            ("Overdraw: current balance is $this->currentBalance, you tried to subtract $amount.\n");
        } else {
            $this->currentBalance -= $amount;
            $this->listOfOperations[] = "-$amount";
        }
    }
}