<?php

namespace App\Helper\Utils\Enums\Roles;

use App\Helper\Utils\Enums\Permissions\Permissions;
use App\Helper\Utils\Enums\Permissions\Resources;

enum Roles: string
{
    case SuperAdmin = 'super_admin';
    case Admin = 'admin';
    case CompanyOwner = 'company_owner';
    case Employee = 'employee';
    case Viewer = 'viewer';
    case Editor = 'editor';

    public function getP():array
    {
        return match ($this){
            self::SuperAdmin => Permissions::all_permissions(),
            self::CompanyOwner,self::Admin => Permissions::normal_permissions(),
            self::Employee=>Resources::editor(Permissions::editor()),
            self::Viewer => Resources::editor(Permissions::view()),
            self::Editor => Resources::admin(Permissions::admin()),

        };
    }

}


