<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Receipt>
 */
class ReceiptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cashTotalSum = fake()->numberBetween(3000, 4000);
        $creditSum = fake()->numberBetween(3000, 4000);
        $ecashTotalSum = fake()->numberBetween(3000, 4000);
        $taxation_type_ids = [1, 2, 4, 8, 32];

        return [
            'dateTime' => fake()->dateTime(),
            'cashTotalSum' => $cashTotalSum,
            'creditSum' => $creditSum,
            'ecashTotalSum' => $ecashTotalSum,
            'code' => random_int(100000, 999999),
            'fiscalDocumentFormatVer' => random_int(100000, 999999),
            'fiscalDocumentNumber' => random_int(100000, 999999),
            'fiscalDriveNumber' => random_int(100000, 999999),
            'fiscalSign' => random_int(100000, 999999),
            'kktRegId' => Str::random(10),
            'nds0' => fake()->numberBetween(10, 300),
            'ndsNo' => fake()->numberBetween(10, 300),
            'nds10' => fake()->numberBetween(10, 300),
            'nds18' => fake()->numberBetween(10, 300),
            'operationType' => random_int(1, 4),
            'prepaidSum' => fake()->numberBetween(5000, 8000),
            'provisionSum' => 0,
            'requestNumber' => fake()->numberBetween(10, 100),
            'retailPlace' => fake()->city(),
            'retailPlaceAddress' => fake()->address(),
            'shiftNumber' => fake()->numberBetween(1, 500),
            'operator' => fake()->name(),
            'taxationType' => $taxation_type_ids[random_int(0, 4)],
            'totalSum' => $cashTotalSum + $creditSum + $ecashTotalSum,
            'user' => fake()->name(),
            'userInn' => substr((string) fake()->creditCardNumber(), 0, 12),
            'user_id' => 1,
            'okved_id' => 1,
        ];
    }
}
