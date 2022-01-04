<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();

        DB::table('tour')->insert([
            'title' => $faker->realText(10),
            'description' => $faker->realText(),
            'img' => 'test',
            'updated_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'role' => 'admin',
            'remember_token' => 'adminTokenTest',
            'login' => 'testAdmin',
            'password' => Hash::make('testAdmin'),
            'firstname' => 'test',
            'lastname' => 'test',
            'avatar' => 'test',
            'updated_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
