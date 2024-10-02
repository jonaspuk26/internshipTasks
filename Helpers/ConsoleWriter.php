<?php

include_once __DIR__ . '/IBankWriter.php';

class ConsoleWriter implements IBankWriter
{
    public function Write($text): void
    {
        print date(DATE_RFC2822) . " " . $text;
    }
}