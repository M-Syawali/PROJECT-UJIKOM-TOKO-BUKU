<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
       // Data pengguna awal
       $users = [
        [
            'username' => 'admin',
            'password' => Hash::make('123'),
            'nama' => 'Muhamad W.Syawali',
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'username' => 'kasir',
            'password' => Hash::make('123'),
            'nama' => 'Egi Renaldi',
            'role' => 'kasir',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'username' => 'owner',
            'password' => Hash::make('123'),
            'nama' => 'Renaldi Nurmazid',
            'role' => 'owner',
            'created_at' => now(),
            'updated_at' => now()
        ]
    ];

    // Insert data pengguna ke dalam tabel
    DB::table('users')->insert($users);
    }
}
