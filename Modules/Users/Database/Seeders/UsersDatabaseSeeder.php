<?php

namespace Modules\Users\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Users\Entities\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('users')->truncate();
        DB::table('roles')->truncate();

        /** @var User $user */
        $user = User::query()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123qaz')
        ]);

        /** @var Role $role */
        $role = Role::create(['name' => 'Admin','guard_name' => 'admin']);

        $permissions = Permission::query()->pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole($role->name);
    }
}
