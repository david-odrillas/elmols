<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Reset cached roles and permissions
      app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

      // create permissions
      // Permission::create(['name' => 'products.index']);
      // Permission::create(['name' => 'products.create']);
      // Permission::create(['name' => 'products.update']);
      // Permission::create(['name' => 'products.destroy']);
      // Permission::create(['name' => 'products.show']);

      $roleAdmin = Role::create(['name' => 'super-admin']);

      // $roleClient = Role::create(['name' => 'client'])
      //     ->givePermissionTo(Permission::all());
      //create user super-admin
      $userAdmin = User::create([
        'name' => 'Freddy Luque',
        'ci' => '123456',
        'cell' => '67654449',
        'email' => 'admin@elmols.com',
        'password' => Hash::make('adminluque')
      ]);
      $userAdmin->assignRole($roleAdmin);

    }
}
