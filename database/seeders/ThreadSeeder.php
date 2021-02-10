<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Thread;
use Illuminate\Support\Facades\DB;


class ThreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $text = "Hey Faggots,

        My name is John, and I hate every single one of you. All of you are fat, retarded, no-lifes who spend every second of their day looking at stupid ass pictures. You are everything bad in the world. Honestly, have any of you ever gotten any pussy? I mean, I guess it's fun making fun of people because of your own insecurities, but you all take to a whole new level. This is even worse than jerking off to pictures on facebook.
        
        Don't be a stranger. Just hit me with your best shot. I'm pretty much perfect. I was captain of the football team, and starter on my basketball team. What sports do you play, other than 'jack off to naked drawn Japanese people'? I also get straight A's, and have a banging hot girlfriend (She just blew me; Shit was SO cash). You are all faggots who should just kill yourselves. Thanks for listening.
        
        Pic Related: It's me and my bitch";

        DB::table('threads')->insert([
            'board_id' => 7,
            'user_id' => 1,
            'title' => 'My name is John',
            'slug' => 'my-name-is-john',
            'thread_text' => $text,
            'thread_image' => 'DTNCYCJ.jpg',
            'created_at' => now(),
            
        ]);

        Thread::factory()->times(20)->create();
    }
}
