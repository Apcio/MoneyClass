<?php

require_once(__DIR__ . "/../vendor/simpletest/simpletest/autorun.php");

class MoneyClassTest extends TestSuite
{
    public function __construct()
    {
        parent::__construct('Testowanie klasy Money');

        $this->addFile(__DIR__ . "/unitTest/moneyUnitTest.php");
        $this->addFile(__DIR__ . "/unitTest/currencyUnitTest.php");
    }
}