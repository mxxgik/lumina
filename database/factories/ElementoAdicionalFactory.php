<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ElementoAdicional>
 */
class ElementoAdicionalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre_elemento' => $this->faker->word(),
            'path_foto_elemento' => $this->faker->imageUrl(),
            'equipos_o_elementos_id' => EquipoOElementoFactory::factory(),
        ];
    }
}
