<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\NivelFormacion;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Formacion>
 */
class FormacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nivel_formacion_id' => NivelFormacion::factory(),
            'ficha' => $this->faker->numberBetween(100000, 999999),
            'nombre_programa' => $this->faker->sentence(3),
            'fecha_inicio_programa' => $this->faker->date(),
            'fecha_fin_programa' => $this->faker->date(),
        ];
    }
}
