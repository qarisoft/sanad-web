<?php

namespace App\Traits;

use App\Helper\Geocoder\Point;

trait Polygons
{
    function pointOnVertex($point, $points): bool
    {
        foreach ($points as $p) {
            if ($p->equal($point)) {
                return true;
            }
        }
        return false;
    }

    public function checkPointPosition(Point $point, $points): string
    {
//        $points = $this->points;
        $intersections = 0;
        for ($i = 1; $i < count($points); $i++) {

            $v1 = $points[$i - 1];

            $v2 = $points[$i];

            if ($v1->equalY($v2) and $v1->equalY($point) and $point->compare($v1, $v2)) return 'vertex';


            if ($point->bigY($v1, $v2) and $point->less_eqY($v1, $v2) and $point->less_eqX($v1, $v2) and !$v1->equal($v2)) {
                $inters = $point->x_inters($v1, $v2);
                if ($inters == $point->getX()) { // Check if point is on the polygon boundary (other than horizontal)
                    return "boundary";
                }
                if ($v1->getX() == $v2->getX() || $point->getX() <= $inters) {
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
}
