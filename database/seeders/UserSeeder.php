<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); // Desactivamos la revisión de claves foráneas
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); // Reactivamos la revisión de claves foráneas

        User::create([
            'name' => 'Carlos Millan',
            'email' => 'cfmillanm@gmail.com',
            'username' => 'cfmillanm',
            'email_verified_at' => now(),
            'password' => Hash::make('qwer1234'),
            'remember_token' => Str::random(10),
        ]);

        User::factory()->count(20)->create();
    }
}
