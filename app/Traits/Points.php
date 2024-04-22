<?php

namespace App\Traits;

use App\Models\Map\Point;

trait Points
{

    public function equal(Point $p):bool
    {

        return $this->x == $p->x and  $this->y == $p->y;
    }

    public function equalY(Point $point):bool
    {
        return $this->y==$point->y;
    }
    public function equalX(Point $point):bool
    {
        return $this->x==$point->x;
    }

    public function bigX(Point $p1,Point $p2):bool
    {
        return $this->x > min($p1->x, $p2->x);
    }
    public function lessX(Point $p1,Point $p2):bool
    {
        return $this->x < max($p1->x, $p2->x);
    }
    public function less_eqX(Point $p1,Point $p2):bool
    {
        return $this->x <= max($p1->x, $p2->x);
    }
    public function bigY(Point $p1,Point $p2):bool
    {
        return $this->y > min($p1->y, $p2->y);
    }
    public function lessY(Point $p1,Point $p2):bool
    {
        return $this->y < max($p1->y, $p2->y);
    }
    public function less_eqY(Point $p1,Point $p2):bool
    {
        return $this->y <= max($p1->y, $p2->y);
    }

    public function compare(Point $p1,Point $p2):bool
    {
        return $this->bigX($p1,$p2) and $this->lessX($p1,$p2);
    }

    public function x_inters(Point $v1,Point $v2): float|int
    {
        return ($this->y - $v1->y) * ($v2->x - $v1->x) / ($v2->y - $v1->y) + $v1->x;
    }
    function distance(
        Point $point,bool $inMeters=false,$earthRadius = 6371000): float|int
    {
        $latFrom = deg2rad($this->x);
        $lonFrom = deg2rad($this->y);
        $latTo = deg2rad($point->x);
        $lonTo = deg2rad($point->y);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $inMeters ? intval($angle * $earthRadius) : $angle * $earthRadius;
    }
}
