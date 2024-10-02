<?php
include_once __DIR__ . '/IBankWriter.php';

class ConsoleAndLogWriter implements IBankWriter
{
    public function Write($text): void
    {
        print date(DATE_RFC2822) . " " . $text;
        file_put_contents
        (
            __DIR__ . "/logs.txt",
            date(DATE_RFC2822) . " " . $text,
            FILE_APPEND
        );
    }

}