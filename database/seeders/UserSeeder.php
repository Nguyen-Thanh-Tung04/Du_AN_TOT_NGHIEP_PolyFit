<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        //        $this->call(UserSeeder::class);
        DB::table('users')->insert([
            'name' => 'Tùng dz',
            'email' => 'tung@gmail.com',  // Đúng định dạng email
            'password' => Hash::make('tung123'),
            'user_catalogue_id' => 1,  

        ]);
    }
}