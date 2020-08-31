<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ReferTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
  use RefreshDatabase;
  public function testGuestNoAccess()
  {
   $this->get('/clients/1/refers')
     ->assertRedirect('login');
  }
  public function testSuperAdminAccess()
  {
    $role = Role::create(['name' => 'super-admin']);
    $user = factory(User::class)->create();
    $user->assignRole($role);
    $this->actingAs($user);
    $this->get('/clients/1/refers')
     ->assertOk();
  }
  public function testUserPermissionNoAccess()
  {
    $role = Role::create(['name' => 'partner']);
    $user = factory(User::class)->create();
    $user->assignRole($role);
    $this->actingAs($user);
    $this->get('/clients/1/refers')
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
    $this->get('/clients/1/refers')
      ->assertOk();
  }
  /*
  * Listas de Referidos.
  **/
  public function testListEmpty()
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
    $this->get('clients')
      ->assertSee('Ver Referidos');
    $this->get('/clients/1/refers')
      ->assertSee(' No tiene Referidos.');
  }
  public function testListNoEmpty()
  {
    Permission::create(['name' => 'users.index']);
    Permission::create(['name' => 'users.create']);
    $role = Role::create(['name' => 'admin'])
      ->givePermissionTo(Permission::all());
    $user = factory(User::class)->create([
     'name' => 'Freddy Luque',
     'ci'   =>  987654321,
     'cell'     => '789456123'
    ]);
    $user->assignRole($role);
    $this->actingAs($user);
    $this->post('/clients',[
        'ci'    => '456123',
        'name' =>'Saint Luque',
        'cell'   => '789456123'
      ])->assertRedirect('clients');
    $this->get('clients')
      ->assertSee('Ver Referidos');
    $this->get('/clients/1/refers')
      ->assertSee('SAINT LUQUE');
  }
  /**
  *   Crear referido por cliente.
  */
  public function testCreateGuestNoAccess()
  {
    factory(User::class)->create();
    $this->get('/clients/1/refers/create')
      ->assertRedirect('login');
  }
  public function testCreatePermissionNoAccess()
  {
    Permission::create(['name' => 'users.index']);
    $role = Role::create(['name' => 'admin'])
      ->givePermissionTo(Permission::all());
    $user = factory(User::class)->create();
    $user->assignRole($role);
    $this->actingAs($user);
    $this->get('/clients/1/refers')->assertDontSee('Agregar Referido');
    $this->get('/clients/1/refers/create')
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
    $this->get('/clients/1/refers')->assertSee('Agregar Referido');
    $this->get('/clients/1/refers/create')->assertSee('Registrar Cliente');
    $this->get('/clients/1/refers/create')->assertSee('Patrocinador:');
    $this->post('/clients/1/refers',[
        'ci'    => '456123',
        'name' =>'Freddy Luque',
        'cell'   => '789456123',
        'user_id' => 1
      ])->assertRedirect('clients/1/refers');
    $this->assertDatabaseHas('users', ['ci' => '456123']);
  }
}
