<?php

namespace helpers\currency\dummy;

require_once(__DIR__ . "/currency.php");

use helpers\currency\currency\currencyInterface;

class dummyCurrency implements currencyInterface {
    public function __construct() {
    }

    public function __set($field, $value) {}

    public function getName(): string {
        return "";
    }

    public function getFullName(): string {
        return "";
    }

    function getFormatted(float $val): string {
        return "";
    }
}

?>