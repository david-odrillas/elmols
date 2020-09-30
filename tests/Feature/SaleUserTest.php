<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use App\Sale;
use App\Product;

class SaleUserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function testGuestNoAccess()
    {
     $this->get('/clients/1/sales')
        ->assertRedirect('login');
    }
    public function testSuperAdminAccess()
    {
     $role = Role::create(['name' => 'super-admin']);
     $user = factory(User::class)->create();
     $user->assignRole($role);
     $this->actingAs($user);
     $this->get('/clients/1/sales')
        ->assertOk();
    }
    public function testUserPermissionNoAccess()
    {
     $role = Role::create(['name' => 'partner']);
     $user = factory(User::class)->create();
     $user->assignRole($role);
     $this->actingAs($user);
     $this->get('/clients/1/sales')
        ->assertForbidden();
    }
    public function testUserPermissionAccess()
    {
     $permission = Permission::create(['name' => 'sales.index']);
     $role = Role::create(['name' => 'admin'])
      ->givePermissionTo($permission);
     $user = factory(User::class)->create();
     $user->assignRole($role);
     $this->actingAs($user);
     $this->get('/clients/1/sales')
     ->assertOk();
    }
    //cliente sin compra..
    public function testListEmpty()
    {
      $permission = Permission::create(['name' => 'sales.index']);
      $role = Role::create(['name' => 'admin'])
      ->givePermissionTo($permission);
      $user = factory(User::class)->create();
      $user->assignRole($role);
      $this->actingAs($user);
      $this->get('/clients/1/sales')
      ->assertOk();
      $this->get('/clients/1/sales')
        ->assertSee('El cliente no tiene compras registradas.');

    }
    /*
    ** ventas con cliente id<> 1.
    */
    public function testUserCreate()
    {
      Permission::create(['name' => 'sales.index']);
      Permission::create(['name' => 'sales.create']);
      $role = Role::create(['name' => 'admin'])
       ->givePermissionTo(Permission::all());
      $user = factory(User::class)->create();
      $user->assignRole($role);
      $this->actingAs($user);
      //crear otro usuario
      factory(User::class)->create([
        'user_id' =>1
      ]);
      //crear Unidades;
      $maiz = Product::create([ 'name' => 'maiz']);
      $maiz->units()->create(['volumen' => 'cuartilla','price' =>  5.5,'sponsor' => .25, 'quantity' => 6, 'supsponsor' => .2]);
      $maiz->units()->create(['volumen' => 'arroba','price' =>  10, 'quantity' => 25, 'sponsor' => 1,'supsponsor' => .7]);
      $trigo = Product::create(['name' => 'trigo']);
      $trigo->units()->create(['volumen' => 'cuartilla','price' =>  6, 'quantity' => 6,'sponsor' => .25,'supsponsor'=> .2]);
      $trigo->units()->create(['volumen' => 'arroba','price' =>  11, 'quantity' => 25,'sponsor' => 1,'supsponsor' => .7]);
      //registrar venta.
      $this->get('/clients/2/sales/create')
        ->assertSee('Realizar Venta');
      $this->post('/clients/2/sales',['amount' =>17.5, 'unit_id' => array(0 => '3', 1 => '1'), 'quantity' => array(0 => '2',1 => '1')] )->assertRedirect('sales');
      $this->assertDatabaseHas('sales', ['amount' => 17.5]);
      $this->assertDatabaseHas('details', ['unit_id' => 3, 'quantity' => 2]);
    }
}
