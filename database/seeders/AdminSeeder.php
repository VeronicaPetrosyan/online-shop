<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin111')
        ]);

        Admin::create([
            'name' => 'Admin2',
            'email' => 'admin2@example.com',
            'password' => Hash::make('admin222')
        ]);
    }
}
