<?php

namespace App\Services;

class NdsProcentService
{
    public static function getDefaultProcent(string $date)
    {
        if (date('Y', strtotime($date)) >= 2026) {
            return 22;
        }

        return 20;
    }
}
