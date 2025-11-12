<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Historial>
 */
class HistorialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'usuario_id' => UserFactory::factory(),
            'equipos_o_elementos_id' => EquipoOElementoFactory::factory(),
            'ingreso' => $this->faker->dateTime(),
            'salida' => $this->faker->optional()->dateTime(),
        ];
    }
}
