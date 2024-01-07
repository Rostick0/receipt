<?php

namespace Database\Seeders;

use App\Models\TaxationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'ОСН',
                'id' => 1,
            ],
            [
                'name' => 'УСН',
                'id' => 2,
            ],
            [
                'name' => 'УСН доход - расход',
                'id' => 4,
            ],
            [
                'name' => 'ЕНВД',
                'id' => 8,
            ],
            [
                'name' => 'ПСН',
                'id' => 32,
            ],
        ];

        TaxationType::insert($data);
    }
}
