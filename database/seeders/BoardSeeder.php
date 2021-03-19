<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Sequence;


class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); // Desactivamos la revisión de claves foráneas
        DB::table('boards')->truncate();
        //DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); // Reactivamos la revisión de claves foráneas

        Board::factory()
        ->count(5)
        ->state(new Sequence(
            ['name' => 'Television',
            'key' => 'tv'],
            ['name' => 'Photos',
            'key' => 'p'],
            ['name' => 'Spain',
            'key' => 'e'],
            ['name' => 'Random',
            'key' => 'b',
            'user_id' => 1],
            ['name' => 'Opinion',
            'key' => 'pol'],
        ))
        ->create();
    }
}
