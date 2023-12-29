<?php

namespace Database\Seeders;

use App\Models\Collection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Приход',
                'imitation_id' => 1,
                'type' => 'operation_type',
            ],
            [
                'name' => 'Возврат прихода',
                'imitation_id' => 2,
                'type' => 'operation_type',
            ],
            [
                'name' => 'Расход',
                'imitation_id' => 3,
                'type' => 'operation_type',
            ],
            [
                'name' => 'Возврат расход',
                'imitation_id' => 4,
                'type' => 'operation_type',
            ],

            [
                'name' => 'ОСН',
                'imitation_id' => 1,
                'type' => 'taxation_type',
            ],
            [
                'name' => 'УСН',
                'imitation_id' => 2,
                'type' => 'taxation_type',
            ],
            [
                'name' => 'УСН доход - расход',
                'imitation_id' => 4,
                'type' => 'taxation_type',
            ],
            [
                'name' => 'ПСН',
                'imitation_id' => 32,
                'type' => 'taxation_type',
            ],
            [
                'name' => 'ЕНВД',
                'imitation_id' => 8,
                'type' => 'taxation_type',
            ],
        ];

        Collection::insert($data);
    }
}
