<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\Receipt;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            TaxationTypeSeeder::class,
            OperationTypeSeeder::class,
            OkvedSeeder::class,
            UserSeeder::class,
        ]);

        Receipt::factory(50)
            ->has(Product::factory(3), 'products')
            ->create();
    }
}
