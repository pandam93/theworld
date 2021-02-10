<?php

namespace Database\Seeders;

use App\Models\Reply;
use Illuminate\Database\Seeder;

class ReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reply::factory()->create([
            'reply_image' => 'pngegg (1).png'
        ]);
        Reply::factory()->times(2)->create(); 
    }
}
