<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rolesList = array('god','admin','manager','moderator','user','guest');

        foreach($rolesList as $role){
            DB::table('roles')->insert([
                'name' => $role,
                'slug' => $role
            ]);
        }
    }
}
