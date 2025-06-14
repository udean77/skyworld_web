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
        static $counter = 1;
        
        return [
            'kode_customer' => 'CUST' . str_pad($counter++, 3, '0', STR_PAD_LEFT),
            'nama' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'no_telp' => $this->faker->phoneNumber(),
            'password' => bcrypt('password123'), // password default
        ];
    }
}
