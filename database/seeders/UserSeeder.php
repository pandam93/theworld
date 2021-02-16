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
        $user = User::create([
            'name' => 'Carlos Millan',
            'email' => 'cfmillanm@gmail.com',
            'username' => 'cfmillanm',
            'password' => Hash::make('qwer1234'),
        ]);

        $user->save();

        $user->roles()->attach(1);


        User::factory()->times(4)->create();
    }
}
