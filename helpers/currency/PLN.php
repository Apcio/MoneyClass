<?php

namespace helpers\currency\pln;

require_once(__DIR__ . "/currency.php");

use helpers\currency\currency\currencyInterface;

class plnCurrency implements currencyInterface {
    private string $name;
    private string $fullName;

    public function __set($field, $value) {}

    public function __construct() {
        $this->name = "PLN";
        $this->fullName = "polski złoty";
    }

    public function getName(): string {
        return $this->name;
    }

    public function getFullName(): string {
        return $this->fullName;
    }

    function getFormatted(float $val): string {
        return number_format($val, 2, ",", " ") . " " . $this->getName();
    }
}
?>