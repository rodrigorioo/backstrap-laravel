<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('administrators')->insert([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // ROLES & MODELS
        try {
            $role = Role::create(['name' => 'super-admin', 'guard_name' => $guard['name']]);
        } catch(RoleAlreadyExists $e) {

        }

        DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_type' => 'Rodrigorioo\BackStrapLaravel\Models\Administrator',
            'model_id' => 1,
        ]);

        // PERMISSIONS
        Permission::firstOrCreate(['name' => 'listar roles', 'guard_name' => $guard]);
        Permission::firstOrCreate(['name' => 'crear rol', 'guard_name' => $guard]);
        Permission::firstOrCreate(['name' => 'guardar rol', 'guard_name' => $guard]);
        Permission::firstOrCreate(['name' => 'ver rol', 'guard_name' => $guard]);
        Permission::firstOrCreate(['name' => 'editar rol', 'guard_name' => $guard]);
        Permission::firstOrCreate(['name' => 'eliminar rol', 'guard_name' => $guard]);
        Permission::firstOrCreate(['name' => 'editar permisos de rol', 'guard_name' => $guard]);
    }
}
