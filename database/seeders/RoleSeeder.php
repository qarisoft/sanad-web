<?php

namespace Database\Seeders;

use App\Helper\Utils\Enums\Roles\Roles;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $super = Role::firstOrCreate(['name' => Roles::SuperAdmin->value,'guard_name'=>'web']);
        $admin = Role::firstOrCreate(['name' => Roles::Admin->value,'guard_name'=>'web']);
        $company_owner = Role::firstOrCreate(['name' => Roles::CompanyOwner->value,'guard_name'=>'web']);

        $super->syncPermissions(Permission::all());
        $admin->syncPermissions(collect(Roles::Admin->getP())->map(fn($p)=>Permission::firstOrCreate([
            'name'=>$p

        ]))->all());
        $company_owner->syncPermissions(collect(Roles::Admin->getP())->map(fn($p)=>Permission::firstOrCreate([
            'name'=>$p

        ]))->all());
        $write_role = Role::firstOrCreate(['name' => 'writer','guard_name'=>'web']);
        $view_role = Role::firstOrCreate(['name' => 'view','guard_name'=>'web']);

        $write_role->syncPermissions(
            collect(Roles::Editor->getP())->map(fn($p)=>Permission::firstOrCreate([
                'name'=>$p

            ]))->all()
        );

        $view_role->syncPermissions(
            collect(Roles::Employee->getP())->map(fn($p)=>Permission::firstOrCreate([
                'name'=>$p

            ]))->all()
        );

    }
}
