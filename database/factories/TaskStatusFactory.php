<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskStatus>
 */
class TaskStatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>fake()->colorName,
            'color'=>fake()->hexColor,
        ];
    }

    static function makeDefault($data)
    {
        if ($data['default']){
//            $dat=$data;
            unset($data['default']);
            $a = static ::create($data);
            $a->default=true;
        }
//        return
    }
}
