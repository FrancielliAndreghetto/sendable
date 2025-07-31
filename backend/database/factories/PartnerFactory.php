<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PartnerFactory extends Factory
{
    protected $model = \App\Models\Partner::class;

    public function definition()
    {
        $name = fake()->company();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
