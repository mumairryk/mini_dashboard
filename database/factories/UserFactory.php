<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class UserFactory extends Factory
{
    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $password = Hash::make('password');
        $phone = Arr::random([
            92038480023,
            9203757057,
            9203790777,
            9203740077,
            9203740075,
            9203757055,
            9203792111,
        ]);
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $password,
            'phone' => $phone,
        ];
    }
}
