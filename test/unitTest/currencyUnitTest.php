<?php

require_once(__DIR__ . "/../../helpers/currency/dummy.php");
require_once(__DIR__ . "/../../helpers/currency/PLN.php");
require_once(__DIR__ . "/../../helpers/currency/USD.php");

use helpers\currency\pln\plnCurrency;
use helpers\currency\usd\usdCurrency;
use helpers\currency\dummy\dummyCurrency;

class currencyUnitTest extends UnitTestCase {
    public function testPLNTextFormatCase() {
        $c = new plnCurrency();
        $this->assertEqual($c->getFormatted(3.65), "3,65 PLN", "Błędnie sformatowana wartość");
        $this->assertEqual($c->getFormatted(12556.2248), "12 556,22 PLN", "Błędnie sformatowana wartość");
        $this->assertEqual($c->getFormatted(4.4288), "4,43 PLN", "Błędnie sformatowana wartość");
        $this->assertEqual($c->getFormatted(3.2), "3,20 PLN", "Błędnie sformatowana wartość");
    }

    public function testUSDTextFormatCase() {
        $c = new usdCurrency();
        $this->assertEqual($c->getFormatted(3.65), "$3.65", "Błędnie sformatowana wartość");
        $this->assertEqual($c->getFormatted(12556.2248), "$12,556.22", "Błędnie sformatowana wartość");
        $this->assertEqual($c->getFormatted(4.4288), "$4.43", "Błędnie sformatowana wartość");
        $this->assertEqual($c->getFormatted(3.2), "$3.20", "Błędnie sformatowana wartość");
    }

    public function testDummyTextFormatCase() {
        $c = new dummyCurrency();
        $this->assertEqual($c->getFormatted(3.65), "", "Błędnie sformatowana wartość");
    }
}