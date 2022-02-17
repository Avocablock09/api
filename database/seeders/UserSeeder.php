<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'Pengguna 1',
            'email' => 'Pengguna1@gmail.com',
            'no_telp' => '0361-123456',
            'alamat' => 'alamat pengguna 1'
        ]);
    }
}
