<?php

namespace helpers\money;

use helpers\currency\currency\currencyInterface;
use helpers\currency\dummy\currencyDummy;
use helpers\currency\dummy\dummyCurrency;
use InvalidArgumentException;


include(__DIR__ . "/currency/currency.php");

class Money {
    private float $value;
    private currencyInterface $currency;
    private bool $valid;

    private function validateValue($val) {
        if(!is_float($val)) return false;

        return true;
    }

    private function validateOperator($m) {
        if(!is_a($m, "helpers\money\Money")) return false;
        if($m->isValid() == false) return false;
        if(get_class($m->getCurrency()) !== get_class($this->currency)) return false;

        return true;
    }

    private function validateCurrency($curr) {
        if(!class_implements($curr, "helpers\currency\currencyInterface")) return false;

        return true;
    }

    public function __set($field, $value) {}

    public function __construct(float $value, currencyInterface $currency) {
        $this->valid = false;

        if($this->validateValue($value) !== true) {
            throw new InvalidArgumentException("Zły argument 'value'");            
        }

        if($this->validateCurrency($currency) !== true) {
            throw new InvalidArgumentException("Zły argument 'currency'");
        }

        if(get_class($currency) !== "helpers\currency\dummy\dummyCurrency") {
            $this->valid = true;
        }

        $this->value = $value;
        $this->currency = $currency;
    }

    public function __toString() {
        if($this->isValid() == false) return "";
        return number_format($this->value, 2, ",", " ") . " " . $this->currency->getName();
    }

    public function isValid() {
        return $this->valid;
    }

    public function getValue() {
        if($this->isValid() == false) return 0;

        return $this->value;
    }

    public function getCurrency() {
        if($this->isValid() == false) return "";

        return $this->currency;
    }

    public function operatorPlus(Money $m) {
        if($this->validateOperator($m) === false) return new Money(0.0, new dummyCurrency());

        $v = $this->getValue() + $m->getValue();
        return new Money(round($v, 2), new $this->currency);
    }

    public function operatorMinus(Money $m) {
        if($this->validateOperator($m) === false) return new Money(0.0, new dummyCurrency());

        $v = $this->getValue() - $m->getValue();
        return new Money(round($v, 2), new $this->currency);
    }

    public function operatorMultiply(Money $m) {
        if($this->validateOperator($m) === false) return new Money(0.0, new dummyCurrency());

        $v = $this->getValue() * $m->getValue();
        return new Money(round($v, 2), new $this->currency);
    }

    public function operatorDivide(Money $m) {
        if($this->validateOperator($m) === false) return new Money(0.0, new dummyCurrency());

        if($m->getValue() !== floatval(0)) {
            $v = $this->getValue() / $m->getValue();
            return new Money(round($v, 2), new $this->currency);
        } else {
            return new Money(floatval(0), new dummyCurrency());
        }

        
    }
    
}
?>