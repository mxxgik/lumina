<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EquipoOElemento>
 */
class EquipoOElementoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sn_equipo' => $this->faker->unique()->uuid(),
            'marca' => $this->faker->company(),
            'color' => $this->faker->colorName(),
            'tipo_elemento' => $this->faker->randomElement(['equipo', 'elemento']),
            'descripcion' => $this->faker->sentence(),
            'qr_hash' => $this->faker->md5(),
            'path_foto_equipo_implemento' => $this->faker->imageUrl(),
        ];
    }
}
