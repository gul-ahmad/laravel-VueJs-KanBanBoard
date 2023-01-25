<?php

namespace Database\Factories;

use App\Models\Column;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Column>
 */
class ColumnFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Column::class;

    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
