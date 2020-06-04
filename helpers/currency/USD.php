<?php

namespace helpers\currency\usd;

require_once(__DIR__ . "/currency.php");

use helpers\currency\currency\currencyInterface;

class usdCurrency implements currencyInterface {
    private string $name;
    private string $fullName;

    public function __set($field, $value) {}

    public function __construct() {
        $this->name = "$";
        $this->fullName = "dolar amerykański";
    }

    public function getName(): string {
        return $this->name;
    }

    public function getFullName(): string {
        return $this->fullName;
    }

    function getFormatted(float $val): string {
        return $this->getName() . number_format($val, 2, ".", ",");
    }
}
?>