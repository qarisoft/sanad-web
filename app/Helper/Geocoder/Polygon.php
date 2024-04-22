<?php

namespace App\Helper\Geocoder;

//use Ramsey\Collection\Collection;
use Illuminate\Support\Collection;

class Polygon
{
    public Collection $points;

    public function __construct(array $array)
    {
        $this->points = collect($array)->map(fn($p) => $this->addPoint($p));
    }

    public function addPoint(array $cords): Point
    {
        return new Point($cords['lat'], $cords['lng']);
    }

    function pointOnVertex($point): bool
    {
        foreach ($this->points as $p) {
            if ($p->equal($point)) {
                return true;
            }
        }
        return false;
//        return $this->points->filter(fn(Point $p)=>$p->equal($point))->isNotEmpty();
    }

    public function checkPointPosition(Point $point): string
    {
        $intersections = 0;
        for ($i = 1; $i < $this->count(); $i++) {

            $v1 = $this->points[$i - 1];

            $v2 = $this->points[$i];

            if ($v1->equalY($v2) and $v1->equalY($point) and $point->compare($v1, $v2)) return 'vertex';


            if ($point->bigY($v1, $v2) and $point->less_eqY($v1, $v2) and $point->less_eqX($v1, $v2) and !$v1->equal($v2)) {
                $inters = $point->x_inters($v1, $v2);
                if ($inters == $point->getX()) { // Check if point is on the polygon boundary (other than horizontal)
                    return "boundary";
                }
                if ($v1->x == $v2->x || $point->getX() <= $inters) {
                    $intersections++;
                }
            }


        }
        if ($intersections % 2 != 0) {
            return "inside";
        } else {
            return "outside";
        }
    }

    public function count(): int
    {
        return count($this->points);
    }


}
