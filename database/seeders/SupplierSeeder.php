<?php

namespace Database\Seeders;


use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        $data = [];
        $id = DB::table("suppliers")->max("id") + 1;

        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'id' => $id++,
                'firstname' => $faker->firstName(),
                'lastname' => $faker->lastName(),
                'email' => $faker->email(),
                'phone' => $faker->phoneNumber(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table("suppliers")->insert($data);
    }
}
