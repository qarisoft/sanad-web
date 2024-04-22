<?php

namespace App\Helper\Utils\Enums\Permissions;

enum Panels:string
{
    case Admin='admin';
    case Company='company';

    public function permissions():array
    {
        return collect(['access','register'])->map(fn(string $c)=>"{$c}_{${$this->value}}")->all();
    }
}
