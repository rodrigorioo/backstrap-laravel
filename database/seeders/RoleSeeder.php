<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $guard = config('backstrap_laravel.guard');

        try {
            $role = Role::create(['name' => 'super-admin', 'guard_name' => $guard['name']]);
        } catch(RoleAlreadyExists $e) {

        }
    }
}
