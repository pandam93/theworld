<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionsList = array(   'See thread' => 'see-thread',
                                    'See board' =>'see-board',
                                    'Create thread' => 'create-thread',
                                    'Create reply' => 'create-reply',
                                    'Edit thread' => 'edit-thread',
                                    'Edit reply' => 'edit-reply',
                                    'Delete thread' => 'delete-thread',
                                    'Delete reply' => 'delete-reply');

        foreach($permissionsList as $key => $value){
            DB::table('permissions')->insert([
                'name' => $key,
                'slug' => $value,
            ]);
        }

    }
}
