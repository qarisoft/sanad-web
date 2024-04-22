<?php

namespace App\Helper\Utils\Enums\Permissions;

enum Permissions:string
{
    case View='view';
    case ViewAny='view_any';
    case Access='access';
    case Delete='delete';
    case DeleteAny='delete_any';
    case Edit='edit';
    case EditAny='edit_any';
    case Create='create';
    case Update='update';
    case UpdateAny='update_any';

    public function can(Resources $r):string
    {
        return $this->value.'_'.$r->value;
    }

    public function resources():array
    {
        return match ($this){
            self::Access=>[Resources::CompanyPanel, Resources::AdminPanel],
            self::Edit,self::Delete,self::DeleteAny,self::Create,self::ViewAny,self::View=>Resources::cases()
        };
    }

    static public function view():array
    {
        return [Permissions::View,Permissions::ViewAny,Permissions::Access];
    }

    static public function editor():array
    {
        return [
            ...Permissions::view(),
            Permissions::Edit,
            Permissions::Create,
        ];
    }

    static public function admin():array
    {
        return [
          ...Permissions::editor(),
          Permissions::Delete,
          Permissions::DeleteAny
        ];
    }

    static function all_permissions():array
    {
        return collect(Resources::cases())->map(fn(Resources $r)=>$r->permissions())->flatten()->all();
    }

    static public function normal_permissions():array
    {
        return collect(Resources::cases())->map(function (Resources $r){
            if ($r!= Resources::AdminPanel && $r->value!= Resources::CompanyPanel->value){
                return $r->permissions();
            }
            return null;
        })->filter(fn($a)=>$a)->flatten(1)->toArray();
    }
}
