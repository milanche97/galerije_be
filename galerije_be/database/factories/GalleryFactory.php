<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class GalleryFactory extends Factory
{

    public function definition()
    {
        return [
            'title' => fake()->sentence,
            'description' => fake()->text($maxNbChars = 1000),
            'user_id' => function () {
                return User::all()->random()->id;
            }
        ];
    }
}
