<?php

namespace App\Helper\Utils\Enums\Permissions;

enum Resources: string
{
    case User = 'user';
    case Task = 'task';
    case Location = 'location';
    case Customer = 'customer';
    case Role = 'role';
    case TaskStatus = 'task_status';
    case Company = 'company';
    case AdminPanel='admin_panel';
    case CompanyPanel='company_panel';

    public function permissions(array|null $permissions=null):array
    {
        if ($this==self::AdminPanel || $this==self::CompanyPanel){
            return  [
                "access_$this->value"
            ];
        }
            return collect($permissions??Permissions::cases())
                ->filter(fn(Permissions $p)=>$p->value!=Permissions::Access->value)
                ->map(fn(Permissions $c)=>$c->value.'_'.$this->value)->all();
    }
    static private function view(): array
    {
        return [
          Resources::Task,
          Resources::Location,
          Resources::CompanyPanel
        ];
    }
    static public function per( array $res,array|null $permissions=null):array
    {
        return collect($res)->map(fn($r)=>$r->permissions($permissions))->flatten()->all();
    }
    static public function editor(array|null $permissions=null):array
    {
        return self::per(Resources::view(),$permissions);
    }
    static public function admin(array|null $permissions=null):array
    {
        return self::per([
            ...Resources::view(),
            Resources::Role
        ],$permissions);
    }

    static public function super_admin(): array
    {
        return Permissions::all_permissions();
    }
}
