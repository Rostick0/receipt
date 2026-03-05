<?php

namespace App\Services;

class NdsProcentService
{
    const NDS = [
        11 => 'НДС 22%',
        1 => 'НДС 20%',
        2 => 'НДС 10%',
        7 => 'НДС 5%',
        5 => 'НДС 0%',
        6 => 'НДС не облагается',
        9 => 'НДС 5/105',
        10 => 'НДС 7/107',
        3 => 'НДС 20/120',
        12 => 'НДС 22/122'
    ];

    public function getList(): array
    {
        return array_map(
            fn($key, $value) => [
                'name' => $value,
                'value' => $key
            ],
            array_keys($this::NDS),
            array_values($this::NDS)
        );
    }
}
