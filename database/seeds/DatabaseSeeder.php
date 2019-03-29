<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<=10;$i++){
            DB::table('users')->insert([
                'name' => 'user'.$i,
                'password' => bcrypt('123456'),
            ]);
            DB::table('admins')->insert([
                'name' => 'admin'.$i,
                'password' => bcrypt('123456'),
            ]);
        }
    }
}
