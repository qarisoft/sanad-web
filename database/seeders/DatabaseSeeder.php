<?php

namespace Database\Seeders;

use App\Helper\Utils\Enums\Roles\Roles;
use App\Models\Customer;
//use App\Models\Settings\Defaults;
use App\Models\Location;
use App\Models\Map\Polygon;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            PermissionsSeeder::class,
            RoleSeeder::class,
            PolygonSeeder::class,
            TaskStatusSeeder::class,
            TaskSeeder::class,
        ]);
        User::factory()->create([
            'name'  => 'salah',
            'email' => 'salah@t.t',

        ])
            ->assignRole(Roles::SuperAdmin->value);
        $cUser = User::factory()->create([
            'name'      => 'Company Owner',
            'email'     => 'company@gmail.test',
            'password'  => Hash::make('company'),
            'is_active' => 1,
        ]);

        $users = User::factory(10)
//            ->for(Location::factory(['place_id'=>random_int(1,Polygon::count()-1)]),'item')
            ->create([
                'is_viewer' => true,
                'is_active' => true,
            ]);
        $users->map(fn ($u) => $u->location()->create([
            'place_id' => Polygon::find(
                random_int(1, Polygon::count() - 1)
            )->place_id,
        ]));
        $comp = $cUser->company()->create([
            'name'     => 'MyCompany',
            'owner_id' => $cUser->id,
        ]);

        //        $customers = Customer::factory(10)->hasTasks()->create();

        $comp->customers->map(function ($a) {
            $a->tasks()->factory(40)->create();
        });
        $cUser->assignRole(Roles::CompanyOwner->value);

        $customers = Customer::factory(10)->hasTasks(4)->create();

        $comp->users()->attach($users);

        $comp->customers()->attach($customers);

        $customers->map(function ($a) use ($comp) {
            $a->tasks->map(function ($t) use ($comp) {
                $comp->tasks()->attach($t);
            });
        });
        //        $t=Task::all()->take();

    }
}
