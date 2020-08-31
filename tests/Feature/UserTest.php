<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function testGuestNoAccess()
    {
      $this->get('/clients')
        ->assertRedirect('login');
    }
    public function testSuperAdminAccess()
    {
    $role = Role::create(['name' => 'super-admin']);
    $user = factory(User::class)->create();
    $user->assignRole($role);
    $this->actingAs($user);
    $this->get('/clients')
        ->assertOk();
    }
    public function testUserPermissionNoAccess()
    {
    $role = Role::create(['name' => 'partner']);
    $user = factory(User::class)->create();
    $user->assignRole($role);
    $this->actingAs($user);
    $this->get('/clients')
        ->assertForbidden();
    }
    public function testUserPermissionAccess()
    {
    $permission = Permission::create(['name' => 'users.index']);
    $role = Role::create(['name' => 'admin'])
      ->givePermissionTo($permission);
    $user = factory(User::class)->create();
    $user->assignRole($role);
    $this->actingAs($user);
    $this->get('/clients')
     ->assertOk();
    }
    /*
    *  Nunca la Lista Estara Vacia desde all()
    *  Solo podra estar vacia en la busqueda:
    */
    public function testListNoEmpty()
    {
      $permission = Permission::create(['name' => 'users.index']);
      $role = Role::create(['name' => 'admin'])
        ->givePermissionTo($permission);
      $user = factory(User::class)->create([
       'name' => 'Freddy Saint Luque',
       'ci'   =>  987654321,
       'cell'     => '789456123'
      ]);
      $user->assignRole($role);
      $this->actingAs($user);
      $this->get('/clients')
        ->assertSee('FREDDY SAINT LUQUE', '987654321');
    }
    /**
    *   Crear referido al id=1
    */
    public function testCreateGuestNoAccess()
    {
      $this->get('/clients/create')
        ->assertRedirect('login');
    }
    public function testCreatePermissionNoAccess()
    {
      Permission::create(['name' => 'users.index']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo(Permission::all());
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/clients')->assertDontSee('Registrar Nuevo');
      $this->get('/clients/create')
          ->assertForbidden();
    }
    public function testCreate()
    {
      Permission::create(['name' => 'users.index']);
      Permission::create(['name' => 'users.create']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo(Permission::all());
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/clients')->assertSee('Registrar Nuevo');
      $this->get('/clients/create')->assertSee('Registrar Cliente');
      $this->post('/clients',[
          'ci'    => '456123',
          'name' =>'Freddy Luque',
          'cell'   => '789456123',
          'sponsor'=>1
        ])->assertRedirect('clients');
      $this->assertDatabaseHas('users', ['ci' => '456123']);
    }
    /*
    *  SEARCH
    */
    public function testSearch()
    {
      factory(User::class)->create([
        'name' => 'Freddy Luque',
        'ci'   =>  987654321,
        'cell'     => '789456123'
      ]);
      $permission = Permission::create(['name' => 'users.index']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo($permission);
      $user = factory(User::class)->create([
        'name'  => 'David Odrillas'
      ]);
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/clients?name=fre')->assertSee('FREDDY LUQUE');
      $this->get('/clients?name=bo')->assertSee('No Hay Clientes');
    }

}
