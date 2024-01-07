<?php

namespace Database\Seeders;

use App\Models\Okved;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OkvedObserver extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [ 
            [
                'id' => 1,
                'name' => 'Производство синтетических волокон',
                'parent_id' => null,
            ],
        ];

        Okved::insert($data);
    }
}
