<?php
declare(strict_types=1);

include_once __DIR__ . '/../Helpers/IBankWriter.php';

class LimitedBankAccount extends BankAccount
{
    private float $negativeLimit;
    public IBankWriter $console;

    public function __construct(
        IBankWriter $console,
        string      $accountName,
        float       $currentBalance = 0,
        float       $negativeLimit = 0
    )
    {
        $this->console = $console;
        parent::__construct($this->console, $accountName, $currentBalance);
        $this->negativeLimit = $negativeLimit;
    }

    #[Override]
    public function SubtractMoney(float $amount): void
    {
        try {
            $this->SubtractMoneyIfEligible($amount);
            $this->console->Write("$amount was subtracted from your bank account.\n");
        } catch (Exception $e) {
            $this->console->Write($e->getMessage() . " Money was not subtracted.\n");
        }
    }

    #[Override]
    public function PrintHistory(): void
    {
        $this->console->Write("Account limit:$this->negativeLimit\n");
        parent::PrintHistory();
    }

    private function SubtractMoneyIfEligible(float $amount): void
    {
        if ($this->currentBalance - $amount > $this->negativeLimit) {
            $this->currentBalance -= $amount;
            $this->listOfOperations[] = "-$amount";
        } else throw new Exception
        ("Overdraw: your limit is $this->negativeLimit,"
            . " current balance is $this->currentBalance,"
            . " you tried to subtract $amount.");
    }
}