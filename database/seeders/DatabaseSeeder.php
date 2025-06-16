<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
<<<<<<< HEAD
=======
use Illuminate\Support\Facades\DB;
>>>>>>> 7f4954b (Updated Chatbot)

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
<<<<<<< HEAD
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
=======
        // User::factory(10)->withPersonalTeam()->create();

        DB::Statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();

        User::factory()->withPersonalTeam()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'username' => 'testos',
            'first_name' => 'Test',
            'last_name' => 'User',
            'birthday' => date('Y-m-d', strtotime('2000-01-01')),
            'password' => bcrypt('password'), // password
            'email_verified_at' => now(),
        ]);

        $this->call(ExpenseCategorySeeder::class);
>>>>>>> 7f4954b (Updated Chatbot)
    }
}
