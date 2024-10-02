<?php
declare(strict_types=1);

class LimitedBankAccount extends BankAccount
{
    private float $negativeLimit;

    public function __construct(string $accountName,
                                float $currentBalance = 0,
                                float $negativeLimit = 0
    )
    {
        parent::__construct($accountName, $currentBalance);
        $this->negativeLimit = $negativeLimit;
    }

    #[Override]
    public function SubtractMoney(float $amount): void
    {
        if ($this->currentBalance - $amount > $this->negativeLimit) {
            $this->currentBalance -= $amount;
            $this->listOfOperations[] = "-$amount";
        } else throw new Exception
        ("Overdraw: your limit is $this->negativeLimit, current balance is $this->currentBalance,
        you tried to subtract $amount");
    }

    #[Override]
    public function PrintHistory(): void
    {
        print("Account limit:$this->negativeLimit\n");
        parent::PrintHistory();
    }
}