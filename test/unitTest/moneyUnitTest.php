<?php

require_once(__DIR__ . "/../../helpers/moneyClass.php");
require_once(__DIR__ . "/../../helpers/currency/dummy.php");
require_once(__DIR__ . "/../../helpers/currency/PLN.php");
require_once(__DIR__ . "/../../helpers/currency/USD.php");

use helpers\currency\pln\plnCurrency;
use helpers\currency\usd\usdCurrency;
use helpers\currency\dummy\dummyCurrency;
use helpers\money\Money;

class MoneyUnitTest extends UnitTestCase {
    public function testCreate()
    {
        $m = new Money(5.0, new plnCurrency());
        $this->assertNotNull($m, "Test utworzenia obiektu z walutą PLN");

        $m = new Money(5.0, new usdCurrency());
        $this->assertNotNull($m, "Test utworzenia obiektu z walutą USD");

        $m = new Money(5.0, new dummyCurrency());
        $this->assertNotNull($m, "Test utworzenia obiektu bez waluty");   
    }

    public function testValueCase() {
        $m = new Money(5, new plnCurrency());
        $this->assertTrue($m->isValid(), "Obiekt powinien być poprawny");
        $this->assertEqual($m->getValue(), 5, "Błędna wartość");
        $this->assertEqual($m->getValue(), 5.0, "Błędna wartość");

        try {
            new Money("trtr", new dummyCurrency());
        } catch (Error $e) {
            $this->assertIsA($e, "TypeError", "Powinien być błąd typu");
        }
    }

    public function testCurrencyCase() {
        $c = new plnCurrency();
        $m = new Money(5, $c);
        $this->assertTrue($m->isValid(), "Obiekt powinien być poprawny");
        $this->assertEqual($m->getCurrency()->getName(), $c->getName(), "Błędny typ waluty");
        
        try {
            new Money(12.65, "PLN");
        } catch (Error $e) {
            $this->assertIsA($e, "TypeError", "Powinien być błąd typu");
        }
    }

    public function testOperatorPlusCase() {
        $m1 = new Money(12.52, new plnCurrency());
        $m2 = $m1->operatorPlus(new Money(2.1, new plnCurrency()));

        $this->assertTrue($m2->isValid(), "Wynik dodawania powinien być poprawny");
        $this->assertEqual($m2->getValue(), 14.62, "Błędnie dodało wartości");

        $m2 = $m1->operatorPlus(new Money(2.1, new usdCurrency()));
        $this->assertFalse($m2->isValid(), "Wynik dodawania powinien być niepoprawny");
    }

    public function testOperatorMinusCase() {
        $m1 = new Money(7, new plnCurrency());
        $m2 = $m1->operatorMinus(new Money(1.04, new plnCurrency()));

        $this->assertTrue($m2->isValid(), "Wynik odejmowania powinien być poprawny");
        $this->assertEqual($m2->getValue(), 5.96, "Błędnie odjęło wartości");


        $m2 = $m1->operatorMinus(new Money(13.2, new plnCurrency()));
        $this->assertTrue($m2->isValid(), "Wynik odejmowania powinien być poprawny");
        $this->assertEqual($m2->getValue(), -6.2, "Błędnie odjęło wartości");

        $m2 = $m1->operatorMinus(new Money(2.1, new usdCurrency()));
        $this->assertFalse($m2->isValid(), "Wynik odejmowania powinien być niepoprawny");
    }

    public function testOperatorMultiplyCase() {
        $m1 = new Money(127.54, new usdCurrency());
        $m2 = $m1->operatorMultiply(new Money(16.25, new usdCurrency()));

        $this->assertTrue($m2->isValid(), "Wynik mnożenia powinien być poprawny");
        $this->assertEqual($m2->getValue(), 2072.53, "Błędnie pomnożyło wartości");


        $m2 = $m1->operatorMultiply(new Money(0, new usdCurrency()));
        $this->assertTrue($m2->isValid(), "Wynik mnożenia powinien być poprawny");
        $this->assertEqual($m2->getValue(), 0, "Błędnie pomnożyło wartości");

        $m2 = $m1->operatorMultiply(new Money(2.1, new plnCurrency()));
        $this->assertFalse($m2->isValid(), "Wynik mnożenia powinien być niepoprawny");
    }

    public function testOperatorDivideCase() {
        $m1 = new Money(0, new usdCurrency());
        $m2 = $m1->operatorDivide(new Money(5, new usdCurrency()));

        $this->assertTrue($m2->isValid(), "Wynik dzielenia powinien być poprawny");
        $this->assertEqual($m2->getValue(), 0, "Błędnie podzieliło wartości");

        $m1 = new Money(2, new usdCurrency());
        $m2 = $m1->operatorDivide(new Money(0, new usdCurrency()));
        $this->assertFalse($m2->isValid(), "Wynik dzielenia powinien być niepoprawny");

        $m2 = $m1->operatorDivide(new Money(2.1, new plnCurrency()));
        $this->assertFalse($m2->isValid(), "Wynik dzielenia powinien być niepoprawny");
    }
}