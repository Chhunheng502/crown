<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\PrivateMsg;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrivateMsgFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PrivateMsg::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => $this->faker->paragraph(),
        ];
    }
}
