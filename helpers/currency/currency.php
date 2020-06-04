<?php

namespace helpers\currency\currency;

interface currencyInterface {
    function getFullName(): string;
    function getName(): string;
    function getFormatted(float $val): string;
}

?>