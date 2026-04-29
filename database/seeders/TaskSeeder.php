<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Seed tasks using Faker only.
     */
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();

        Task::factory()
            ->count(100)
            ->state(fn () => [
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
            ])
            ->create();
    }
}
