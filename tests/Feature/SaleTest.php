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

class SaleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /*
    *   Buscar con cliente 1, y 2.
    */
    use RefreshDatabase;
    public function testGuestNoAccess()
    {
      $this->get('/home')
         ->assertRedirect('login');
    }
    public function testSuperAdminAccess()
    {
      $role = Role::create(['name' => 'super-admin']);
      $user = factory(User::class)->create();
      $user->assignRole($role);
      $this->actingAs($user);
      $this->get('/home')
         ->assertOk();
    }
    public function testUserPermissionNoAccess()
    {
      $role = Role::create(['name' => 'partner']);
      $user = factory(User::class)->create();
      $user->assignRole($role);
      $this->actingAs($user);
      $this->get('/home')
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
      $this->get('/home')
      ->assertOk();
    }
    //crear ventas con user: id=1
    public function testCreate()
    {
      //$this->withoutExceptionHandling();
      Permission::create(['name' => 'sales.index']);
      Permission::create(['name' => 'sales.create']);
      $role = Role::create(['name' => 'admin'])
       ->givePermissionTo(Permission::all());
      $user = factory(User::class)->create();
      $user->assignRole($role);
      $this->actingAs($user);
      //crear Unidades;
      $maiz = Product::create([ 'name' => 'maiz']);
      $maiz->units()->create(['volumen' => 'cuartilla','price' =>  5.5,'sponsor' => .25, 'quantity' => 6, 'supsponsor' => .2]);
      $maiz->units()->create(['volumen' => 'arroba','price' =>  10, 'quantity' => 25, 'sponsor' => 1,'supsponsor' => .7]);
      $trigo = Product::create(['name' => 'trigo']);
      $trigo->units()->create(['volumen' => 'cuartilla','price' =>  6, 'quantity' => 6,'sponsor' => .25,'supsponsor'=> .2]);
      $trigo->units()->create(['volumen' => 'arroba','price' =>  11, 'quantity' => 25,'sponsor' => 1,'supsponsor' => .7]);
      $this->get('/home')
        ->assertSee('Realizar Venta');
      $this->post('/sales',['amount' =>17.5, 'unit_id' => array(0 => '3', 1 => '1'), 'quantity' => array(0 => '2',1 => '1')] )->assertRedirect('sales');
      // $this->post('/sales',['amount' =>17.5, 'unit_id' => [0 => '3', 1 => '1'], 'quantity' => [0 => '2',1 => '1']] )->assertRedirect('sales.index');
      $this->assertDatabaseHas('sales', ['amount' => 17.5]);
      $this->assertDatabaseHas('details', ['unit_id' => 3, 'quantity' => 2]);
    }
    /*
    ** ventas con cliente id<> 1.
    */
    public function testUserCreate()
    {
      //$this->withoutExceptionHandling();
      Permission::create(['name' => 'sales.index']);
      Permission::create(['name' => 'sales.create']);
      $role = Role::create(['name' => 'admin'])
       ->givePermissionTo(Permission::all());
      $user = factory(User::class)->create();
      $user->assignRole($role);
      $this->actingAs($user);
      //crear Unidades;
      $maiz = Product::create([ 'name' => 'maiz']);
      $maiz->units()->create(['volumen' => 'cuartilla','price' =>  5.5,'sponsor' => .25, 'quantity' => 6, 'supsponsor' => .2]);
      $maiz->units()->create(['volumen' => 'arroba','price' =>  10, 'quantity' => 25, 'sponsor' => 1,'supsponsor' => .7]);
      $trigo = Product::create(['name' => 'trigo']);
      $trigo->units()->create(['volumen' => 'cuartilla','price' =>  6, 'quantity' => 6,'sponsor' => .25,'supsponsor'=> .2]);
      $trigo->units()->create(['volumen' => 'arroba','price' =>  11, 'quantity' => 25,'sponsor' => 1,'supsponsor' => .7]);
      $this->get('/home')
        ->assertSee('Realizar Venta');
      $this->post('/sales',['amount' =>17.5, 'unit_id' => array(0 => '3', 1 => '1'), 'quantity' => array(0 => '2',1 => '1')] )->assertRedirect('sales');
      // $this->post('/sales',['amount' =>17.5, 'unit_id' => [0 => '3', 1 => '1'], 'quantity' => [0 => '2',1 => '1']] )->assertRedirect('sales.index');
      $this->assertDatabaseHas('sales', ['amount' => 17.5]);
      $this->assertDatabaseHas('details', ['unit_id' => 3, 'quantity' => 2]);
    }
    /*
    ** prueba para ver el index.
    */
    public function testListEmpty()
    {
      $permission = Permission::create(['name' => 'sales.index']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo($permission);
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/home')->assertSee('Ventas');
      $this->get('/sales')
       ->assertSee('No hay Ventas Registradas');
    }
    public function testListNoEmpty()
    {
      $this->withoutExceptionHandling();
      Permission::create(['name' => 'sales.index']);
      Permission::create(['name' => 'sales.create']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo(Permission::all());
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/home')->assertSee('Ventas');
      //crear Unidades;
      $maiz = Product::create([ 'name' => 'maiz']);
      $maiz->units()->create(['volumen' => 'cuartilla','price' =>  5.5,'sponsor' => .25, 'quantity' => 6, 'supsponsor' => .2]);
      $maiz->units()->create(['volumen' => 'arroba','price' =>  10, 'quantity' => 25, 'sponsor' => 1,'supsponsor' => .7]);
      $trigo = Product::create(['name' => 'trigo']);
      $trigo->units()->create(['volumen' => 'cuartilla','price' =>  6, 'quantity' => 6,'sponsor' => .25,'supsponsor'=> .2]);
      $trigo->units()->create(['volumen' => 'arroba','price' =>  11, 'quantity' => 25,'sponsor' => 1,'supsponsor' => .7]);
      $this->get('/home')
        ->assertSee('Realizar Venta');
      $this->post('/sales',['amount' =>17.5, 'unit_id' => array(0 => '3', 1 => '1'), 'quantity' => array(0 => '2',1 => '1')] )->assertRedirect('sales');
      //ver venta
      $this->get('/sales')
       ->assertSee('Cliente', 'FREDDY LUQUE');
    }
}
