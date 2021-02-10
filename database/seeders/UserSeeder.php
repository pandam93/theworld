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
        DB::table('users')->insert([
            'name' => 'Carlos Millan',
            'email' => 'cfmillanm@gmail.com',
            'username' => 'cfmillanm',
            'password' => Hash::make('qwer1234'),
        ]);

        User::factory()->times(4)->create();
    }
}
