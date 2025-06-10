<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WahanaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => 'Wahana ' . $this->faker->word,
            'harga' => $this->faker->numberBetween(15000, 100000),
            'stok' => $this->faker->numberBetween(50, 200),
            'deskripsi' => $this->faker->sentence(10),
            'gambar' => $this->faker->imageUrl(640, 480, 'nature', true, 'Wahana', true) . '?random=' . rand(1, 1000),
        ];
    }
}
