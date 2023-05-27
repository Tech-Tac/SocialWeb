<?php

namespace Database\Seeders;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FriendshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $from) {
            foreach ($users as $to) {
                if ($from->id !== $to->id && rand(0, 1) > 0.5) {
                    Friendship::factory()->create([
                        'from_id' => $from->id,
                        'to_id' => $to->id,
                    ]);
                }
            }
        }
    }
}
