<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NivelFormacion>
 */
class NivelFormacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nivel_formacion' => $this->faker->randomElement(['Técnico', 'Tecnólogo', 'Auxiliar', 'Operario', 'Especializacion Tecnologica']),
        ];
    }
}
