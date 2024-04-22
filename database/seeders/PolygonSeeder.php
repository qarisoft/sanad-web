<?php

namespace Database\Seeders;

use App\Models\Map\Polygon;
use Illuminate\Database\Seeder;

class PolygonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $a  = file_get_contents(database_path('data.json'));
        $js = json_decode($a);
        foreach ($js as $place) {
            $data = collect($place->data)->map(fn ($point) => [
                'lat' => $point[1],
                'lng' => $point[0],
            ])->all();

            Polygon::factory()->create([
                'name'     => $place->props->NL_NAME_1,
                'place_id' => $place->props->id,
                'data'     => json_encode($data),

            ])->default = true;
        }
    }
}
