<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registry>
 */
class RegistryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reference_no' => fake()->bothify("RAG-####"),
            'date' => fake()->date('Y-m-d'),
            'sender' => fake()->name(),
            'recipient' => fake()->company(),
            'subject' => fake()->sentence(),
            'remarks' => fake()->sentence(),
            'attachments' => json_encode([]),
        ];
    }
}
