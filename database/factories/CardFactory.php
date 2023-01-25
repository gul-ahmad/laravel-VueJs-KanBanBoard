<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\Column;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Card::class;

    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'description' => $this->faker->sentence(),
            'status' => Card::STATUS_ACTIVE,
            'order' => $this->faker->numberBetween(0, 4),
            'column_id' => Column::factory(),
            // 'created_at' => now(),
            // 'updated_at' => now(),
        ];
    }
}
