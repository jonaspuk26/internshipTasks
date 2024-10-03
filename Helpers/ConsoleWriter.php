<?php

namespace Helpers;

class ConsoleWriter implements IBankWriter
{
    public function Write($text): void
    {
        print date(DATE_RFC2822) . " " . $text;
    }
}