<?php

namespace Database\Seeders;

use App\Helper\Utils\Enums\Permissions\Permissions;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createPermissions(Permissions::all_permissions());
    }

    public function createPermissions(array $names): array
    {
        $a=[];
        foreach ($names as $n => $name) {
            $p=Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ]);
            $a[]=$p;
        }
        return $a;
    }

}
