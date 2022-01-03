<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Rodrigorioo\BackStrapLaravel\Models\Administrator;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class BackStrapLaravelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $guard = config('backstrap_laravel.guard');

        // ADMINISTRATORS
        $administrator = Administrator::where('email', 'admin@admin.com')
            ->first();

        if(empty($administrator)) {
            $administrator = Administrator::create([
                'name' => 'Administrator',
                'email' => 'admin@admin.com',
                'password' => bcrypt('123456'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // ROLES & MODELS
        $role = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => $guard['name']]);

        $administrator->assignRole($role->name);

        // PERMISSIONS
        Permission::firstOrCreate(['name' => 'listar roles', 'guard_name' => $guard['name']]);
        Permission::firstOrCreate(['name' => 'crear rol', 'guard_name' => $guard['name']]);
        Permission::firstOrCreate(['name' => 'guardar rol', 'guard_name' => $guard['name']]);
        Permission::firstOrCreate(['name' => 'ver rol', 'guard_name' => $guard['name']]);
        Permission::firstOrCreate(['name' => 'editar rol', 'guard_name' => $guard['name']]);
        Permission::firstOrCreate(['name' => 'eliminar rol', 'guard_name' => $guard['name']]);
        Permission::firstOrCreate(['name' => 'editar permisos de rol', 'guard_name' => $guard['name']]);
    }
}
