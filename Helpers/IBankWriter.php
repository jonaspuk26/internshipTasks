<?php

namespace Helpers;

interface IBankWriter
{
    public function Write($text): void;
}