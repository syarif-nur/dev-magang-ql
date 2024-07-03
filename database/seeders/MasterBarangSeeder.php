<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MasterBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $data = [];
        $id = DB::table('master_barang')->max('id') + 1;
        for ($i = 0; $i < 5; $i++) {
            $data[] = [
                'id' => $id++,
                'nama_barang' => $faker->word,
                'img_url' => $faker->word,
                'qty' => $faker->word,
                'status' => $faker->numberBetween(1, 100),
                'created_at' =>now(),
                'update_at' => now(),
            ];
        }

        DB::table('master_barang')->insert($data);
    }
}
