<?php

namespace Database\Factories;

use App\Models\Componente;
use App\Models\Miembro;
use Illuminate\Database\Eloquent\Factories\Factory;

class MiembroFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Miembro::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'componente_id' => Componente::create()->id,
            'identificacion' => $this->faker->numberBetween(100000000, 799999999),
            'distrito' => 'Distrito ' . $this->faker->numberBetween(1, 10),
            'canton'=> 'Canton ' . $this->faker->numberBetween(1, 10),
            'sennas' => 'Seña ' . $this->faker->numberBetween(1, 10),
            'provincia' => $this->faker->randomElement(['San José', 'Alajuela', 'Cartago', 'Heredia', 'Guanacaste', 'Puntarenas', 'Limón']),
            'nombreCompleto' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'telefono' => $this->faker->numerify('####-####'),
            'enabled' => true
        ];
    }
}
