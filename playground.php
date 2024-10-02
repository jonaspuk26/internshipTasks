<?php

include __DIR__ . '/Data_models/Customer.php';
include __DIR__ . '/Helpers/ConsoleWriter.php';
include __DIR__ . '/Helpers/ConsoleAndLogWriter.php';

$consoleWriter = new ConsoleAndLogWriter();
$jojo = new Customer($consoleWriter, 'jo', 800);
$bobo = new Customer($consoleWriter, 'bobo1');
/*
var_dump($jojo->GetTotalBalance('jojo'));
$jojo
    ->listOfBankAccounts['jojo']
    ->AddMoney(500);
$jojo->listOfBankAccounts['jojo']->SubtractMoney(200);
var_dump($jojo->GetTotalBalance('jojo'));

$bobo->listOfBankAccounts['bobo1']->AddMoney(600);
$bobo->listOfBankAccounts['bobo1']->SubtractMoney(600);
var_dump($bobo->GetTotalBalance('bobo1'));
$bobo->AddBankAccount('bobo2', 600);
$bobo->listOfBankAccounts['bobo2']->AddMoney(500);
$bobo->listOfBankAccounts['bobo2']->SubtractMoney(100);
$bobo->listOfBankAccounts['bobo2']->SubtractMoney(200);
var_dump($bobo->GetTotalBalance('bobo2'));
$bobo->PrintHistory();
$bobo->PrintStatistics();
$bobo->AddBankAccount('bobo3', 200);
$bobo->CopyBankAccount('bobo3', 'bobo2');
var_dump($bobo->GetTotalBalance('bobo3'));
$bobo->listOfBankAccounts['bobo2']->SubtractMoney(100);
var_dump($bobo->GetTotalBalance('bobo3'));



$bobo->UserInputFromConsole('bobo1');
var_dump($bobo->GetTotalBalance('bobo1'));
*/
$coco = new Customer($consoleWriter, 'coco1', 200, true, true, -200);
var_dump($coco->GetTotalBalance('coco1'));
$coco->listOfBankAccounts['coco1']->AddMoney(200);
$coco->listOfBankAccounts['coco1']->SubtractMoney(500);
var_dump($coco->GetTotalBalance('coco1'));
$coco->listOfBankAccounts['coco1']->SubtractMoney(200);
$coco->PrintHistory();

$coco->PrintStatistics();




