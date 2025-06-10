<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Customer;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name,
            'kode_customer' => 'CUST-' . strtoupper($this->faker->unique()->bothify('###??')),
            'email' => $this->faker->safeEmail,
            'no_telp' => $this->faker->phoneNumber,
            'password' => bcrypt('password123')
        ];
    }
}
