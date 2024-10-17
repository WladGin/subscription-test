<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create([
            'title' => 'Lite',
            'price_per_user' => 4.00,
        ]);

        Plan::create([
            'title' => 'Starter',
            'price_per_user' => 6.00,
        ]);

        Plan::create([
            'title' => 'Premium',
            'price_per_user' => 10.00,
        ]);
    }
}
