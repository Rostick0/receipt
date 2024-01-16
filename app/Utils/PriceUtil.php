<?php

namespace App\Utils;

class PriceUtil
{
    public static function checkAndMultiplication($number, $multiplier = 100) {
        if (!isset($number)) return null;

        return $number * $multiplier;
    }

    public static function checkAndDivision($number, $divider = 100) {
        if (!isset($number)) return null;

        return $number / $divider;
    }
}