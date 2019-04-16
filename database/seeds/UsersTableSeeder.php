<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //default records
        DB::table('users')->insert([
            [
               'name' => 'ShreeHari',
               'email' => 'shreehari@gmail.com',
               'password' => Hash::make('nikhil@0987'),
            ],
            [
               'name' => 'Nikhil',
               'email' => 'nikhil@gmail.com',
               'password' => Hash::make('nikhil@0987'),
           ]
        ]);
    }
}
