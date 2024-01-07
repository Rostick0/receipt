<?php

namespace Database\Seeders;

use App\Models\OperationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Приход',
                'id' => 1,
            ],
            [
                'name' => 'Возврат прихода',
                'id' => 2,
            ],
            [
                'name' => 'Расход',
                'id' => 3,
            ],
            [
                'name' => 'Возврат расход',
                'id' => 4,
            ],
        ];

        OperationType::insert($data);
    }
}
