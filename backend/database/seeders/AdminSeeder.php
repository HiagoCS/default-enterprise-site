<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'id' => 1,
            'name' => 'HiagoCS',
            'cpf' => '37775433817',
            'token' => '',
            'phone' => '11912345678',
            'password' => Hash::make('hiago@1504'),
            'admin' => 1,
        ]);
    }
}
