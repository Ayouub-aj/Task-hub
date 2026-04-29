<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $itKeywords = [
            'Backend',
            'Frontend',
            'DevOps',
            'Security',
            'Testing',
            'Database',
            'API',
            'Cloud',
            'Mobile',
            'Network',
            'Support',
            'Analytics',
            'Automation',
            'Infra',
            'Monitoring',
        ];

        return [
            // One-word meaningful IT category names.
            'name' => fake()->unique()->randomElement($itKeywords),
        ];
    }
}
