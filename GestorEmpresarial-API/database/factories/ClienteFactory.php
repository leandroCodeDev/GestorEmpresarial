<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name(),
            'login' => Str::ascii($this->faker->unique()->userName()),
            'cpf' => $this->faker->unique()->numerify('####.###.###-##'),
            'email' => $this->faker->unique()->email(),
            'senha' => $this->faker->password(),
            'endereco' => $this->faker->address(),
            'documento_path' => $this->faker->unique()->filePath(),
        ];
    }
}
