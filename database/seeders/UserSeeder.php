<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => "Admin",
            'email' => "admin@" . config('app.name') . ".com",
            'about' => "The official admin of " . config('app.name') . ".",
            'email_verified_at' => now(),
            'password' => Hash::make("12345678"),
        ]);

        User::factory()
            ->count(10)
            ->hasPosts(3)
            ->hasComments(3)
            ->create();
    }
}
