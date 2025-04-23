<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('expense_categories')->insert([
            ['name' => 'Food', 'description' => 'Expenses for daily meals, snacks, groceries, or dining out.', 'is_default' => true, 'color_code' => 'FFB74D', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Drink', 'description' => 'Covers purchases of beverages like coffee, tea, bottled water, or soft drinks.', 'is_default' => true, 'color_code' => '4FC3F7', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Health & Beauty', 'description' => 'Includes expenses on personal care items, skincare, cosmetics, and grooming.', 'is_default' => true, 'color_code' => 'F48FB1', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sport', 'description' => 'For spending related to sports activities, gym memberships, or equipment.', 'is_default' => true, 'color_code' => '81C784', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Medical', 'description' => 'Used for medical bills, doctor visits, prescriptions, and other health care.', 'is_default' => true, 'color_code' => '4DB6AC', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Shopping', 'description' => 'General category for non-essential purchases like clothes, gadgets, etc.', 'is_default' => true, 'color_code' => 'BA68C8', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Transport', 'description' => 'Costs related to commuting, public transport, fuel, or ride-hailing services.', 'is_default' => true, 'color_code' => '90A4AE', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bills', 'description' => 'Monthly payments such as utilities, phone bills, subscriptions, or rent.', 'is_default' => true, 'color_code' => '7986CB', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Entertainment', 'description' => 'Spending on leisure activities like movies, games, events, or streaming services.', 'is_default' => true, 'color_code' => 'E57373', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
