<?php

namespace Database\Seeders;

use App\Models\Board;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $boards = array("a"=>"Anime", "v"=>"Games", "g"=>"Technology",
                        "tv"=>"Audivisual", "p"=>"Photos","e"=>"Spain",
                        "b"=>"Random", "pol"=>"Opinion","lit"=>"Literature",
                        "adv"=>"Advice","sp"=>"Sports","bl"=>"blog");

        foreach($boards as $key => $value){

            Board::factory()->create([
                'name' => $value,
                'short_name' => $key,
                'slug' => $key,
            ]);
        }

    }
}
