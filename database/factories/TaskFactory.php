<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $taskTemplates = [
            ['verb' => 'Prepare', 'object' => 'sprint planning notes'],
            ['verb' => 'Review', 'object' => 'pull request feedback'],
            ['verb' => 'Update', 'object' => 'project documentation'],
            ['verb' => 'Fix', 'object' => 'login validation bug'],
            ['verb' => 'Plan', 'object' => 'weekly engineering goals'],
            ['verb' => 'Finalize', 'object' => 'release checklist'],
            ['verb' => 'Document', 'object' => 'API endpoint behavior'],
            ['verb' => 'Refactor', 'object' => 'task list query'],
            ['verb' => 'Test', 'object' => 'task CRUD scenarios'],
            ['verb' => 'Monitor', 'object' => 'production error logs'],
            ['verb' => 'Deploy', 'object' => 'staging environment update'],
            ['verb' => 'Analyze', 'object' => 'performance bottlenecks'],
            ['verb' => 'Coordinate', 'object' => 'team handoff items'],
            ['verb' => 'Schedule', 'object' => 'stakeholder sync meeting'],
        ];

        $template = fake()->randomElement($taskTemplates);
        $status = fake()->randomElement(['to_do', 'in_progress', 'completed']);

        $priority = match ($status) {
            'to_do' => fake()->randomElement(['low', 'medium', 'high']),
            'in_progress' => fake()->randomElement(['medium', 'high']),
            'completed' => fake()->randomElement(['low', 'medium']),
        };

        $dueDate = match ($status) {
            'completed' => fake()->boolean(75) ? fake()->dateTimeBetween('-20 days', 'now')->format('Y-m-d') : null,
            'in_progress' => fake()->boolean(90) ? fake()->dateTimeBetween('-2 days', '+10 days')->format('Y-m-d') : null,
            default => fake()->boolean(85) ? fake()->dateTimeBetween('now', '+21 days')->format('Y-m-d') : null,
        };

        return [
            'title' => $template['verb'].' '.$template['object'],
            'description' => fake()->optional(0.9)->randomElement([
                'Coordinate with the team and post a concise update in the project channel.',
                'Ensure acceptance criteria are met before moving to the next status.',
                'Capture blockers early and document the resolution steps.',
                'Cross-check dependencies and align timeline with stakeholders.',
                'Add implementation notes so maintenance is easier later.',
            ]),
            'status' => $status,
            'priority' => $priority,
            'due_date' => $dueDate,
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
        ];
    }
}
