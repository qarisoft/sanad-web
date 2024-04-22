<?php

namespace Database\Factories;

use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Random\RandomException;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 * @throws RandomException
 */
function str_rand(int $length = 10): string
{ // 64 = 32
    $length = ($length < 4) ? 4 : $length;
    return bin2hex(random_bytes(($length-($length%2))/2));
}
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code'=>str_rand(),
            'must_do_at'=>Carbon::now()->add(rand(1,50),'hours'),
            'received_at'=>date("Y-m-d H:i:s"),
        ];
    }
}
