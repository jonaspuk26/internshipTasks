<?php
include __DIR__ . '/Customer.php';


$jojo = new Customer('jojo', 800);
$bobo = new Customer('bobo1');

var_dump($jojo->GetTotalBalance('jojo'));
$jojo ->listOfBankAccounts['jojo'] -> AddMoney(500);
$jojo ->listOfBankAccounts['jojo'] -> SubtractMoney(200);
var_dump($jojo->GetTotalBalance('jojo'));

$bobo ->listOfBankAccounts['bobo1'] -> AddMoney(500);
$bobo ->listOfBankAccounts['bobo1'] -> SubtractMoney(600);
var_dump($bobo->GetTotalBalance('bobo1'));
$bobo -> AddBankAccount('bobo2', 600);
$bobo -> listOfBankAccounts['bobo2'] -> AddMoney(500);
$bobo -> listOfBankAccounts['bobo2'] -> SubtractMoney(100);
$bobo -> listOfBankAccounts['bobo2'] -> SubtractMoney(200);
var_dump($bobo->GetTotalBalance('bobo2'));
$bobo -> PrintHistory();
$bobo -> PrintStatistics();
$bobo -> AddBankAccount('bobo3', 200);
$bobo -> CopyBankAccount('bobo3','bobo2');
var_dump($bobo->GetTotalBalance('bobo3'));
$bobo -> listOfBankAccounts['bobo2'] -> SubtractMoney(100);
var_dump($bobo->GetTotalBalance('bobo3'));

