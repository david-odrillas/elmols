<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase; 

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use App\Product;
use App\Unit;

class UnitTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function testGuestNoAccess()
    {
      $maiz = Product::create(['name' => 'maiz']);
      $maiz->units()->create([
        'volumen' => 'arroba',
        'price' =>  10,
        'sponsor' => 1,
        'supsponsor' => .7
      ]);
      $this->get('/products/1/units')
        ->assertRedirect('login');
    }
    public function testSuperAdminAccess()
    {
      $maiz = Product::create(['name' => 'maiz']);
      $maiz->units()->create([
        'volumen' => 'arroba',
        'price' =>  10,
        'sponsor' => 1,
        'supsponsor' => .7
      ]);
      $role = Role::create(['name' => 'super-admin']);
      $user = factory(User::class)->create();
      $user->assignRole($role);
      $this->actingAs($user);
      $this->get('/products/1/units')
          ->assertSee('MAIZ');
    }
    public function testUserPermissionNoAccess()
    {
      $maiz = Product::create(['name' => 'maiz']);
      $maiz->units()->create([
        'volumen' => 'arroba',
        'price' =>  10,
        'sponsor' => 1,
        'supsponsor' => .7
      ]);
      $role = Role::create(['name' => 'partner']);
      $user = factory(User::class)->create();
      $user->assignRole($role);
      $this->actingAs($user);
      $this->get('/products/1/units')
          ->assertForbidden();
    }
    public function testUserPermissionAccess()
    {
      $maiz = Product::create(['name' => 'maiz']);
      $maiz->units()->create([
        'volumen' => 'arroba',
        'price' =>  10,
        'sponsor' => 1,
        'supsponsor' => .7
      ]);
      $permission = Permission::create(['name' => 'products.index']);
      $role = Role::create(['name' => 'admin'])
        ->givePermissionTo($permission);
      $user = factory(User::class)->create();
      $user->assignRole($role);
      $this->actingAs($user);
      $this->get('/products/1/units')
       ->assertSee('ARROBA');
    }
    /*
    * Lista Vacia: Productos sin unidades.
    */
    public function testListEmpty()
    {
      $maiz = Product::create(['name' => 'maiz']);
      $permission = Permission::create(['name' => 'products.index']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo($permission);
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/products/1/units')
       ->assertSee('El producto no tiene Unidades registradas');
    }
    public function testListNoEmpty()
    {
      $maiz = Product::create(['name' => 'maiz']);
      $maiz->units()->create([
        'volumen' => 'arroba',
        'price' =>  10,
        'sponsor' => 1,
        'supsponsor' => .7
      ]);
      $permission = Permission::create(['name' => 'products.index']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo($permission);
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/products/1/units')
       ->assertSee('ARROBA', '10');
    }
    /*
    * Ver la opcion de Eliminar, Solo si tiene los permisos
    */
    public function testDeletePermissionDontSee()
    {
      $maiz = Product::create(['name' => 'maiz']);
      $maiz->units()->create([
        'volumen' => 'arroba',
        'price' =>  10,
        'sponsor' => 1,
        'supsponsor' => .7
      ]);
      Permission::create(['name' => 'products.index']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo(Permission::all());
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/products/1/units')
          ->assertSee('ARROBA');
      $this->get('/products/1/units')->assertDontSee('delete-row');
    }
    public function testSoftDelete()
    {
      $maiz = Product::create(['name' => 'maiz']);
      $unit = $maiz->units()->create([
        'volumen' => 'arroba',
        'price' =>  10,
        'sponsor' => 1,
        'supsponsor' => .7
      ]);
      Permission::create(['name' => 'products.index']);
      Permission::create(['name' => 'products.destroy']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo(Permission::all());
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/products/1/units')
          ->assertSee('ARROBA');
      $this->get('/products/1/units')->assertSee('delete-row');
      $this->delete("products/{$maiz->id}/units/{$unit->id}")
          ->assertRedirect('products/1/units');
      $this->assertSoftDeleted($unit);
    }
    /**
    *   Crear
    */
    public function testCreateGuestNoAccess()
    {
      Product::create(['name' => 'maiz']);
      $this->get('/products/1/units/create')
        ->assertRedirect('login');
    }
    public function testCreatePermissionNoAccess()
    {
      Product::create(['name' => 'maiz']);
      Permission::create(['name' => 'products.index']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo(Permission::all());
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/products/1/units')->assertDontSee('Agregar Unidad');
      $this->get('/products/1/units/create')
          ->assertForbidden();
    }
    public function testCreate()
    {
      $product = Product::create(['name' => 'maiz']);
      Permission::create(['name' => 'products.index']);
      Permission::create(['name' => 'products.create']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo(Permission::all());
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/products/1/units')->assertSee('Agregar Unidad');
      $this->get('/products/1/units/create')->assertSee('Crear Unidad');
      $this->post('/products/1/units', ['volumen' => 'arroba', 'price' =>  10, 'sponsor' => 1,     'supsponsor' => .7])->assertRedirect('products/1/units');
      $this->assertDatabaseHas('units', ['volumen' => 'ARROBA']);
    }
    /*
    * Update
    */
    public function testEditGuestNoAccess()
    {
      $maiz = Product::create(['name' => 'maiz']);
      $maiz->units()->create([
        'volumen' => 'arroba',
        'price' =>  10,
        'sponsor' => 1,
        'supsponsor' => .7
      ]);
      $this->get('/products/1/units/1/edit')
        ->assertRedirect('login');
    }
    public function testEditPermissionNoAccess()
    {
      $maiz = Product::create(['name' => 'maiz']);
      $maiz->units()->create([
        'volumen' => 'arroba',
        'price' =>  10,
        'sponsor' => 1,
        'supsponsor' => .7
      ]);
      Permission::create(['name' => 'products.index']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo(Permission::all());
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/products/1/units')->assertDontSee('Editar');
      $this->get('products/1/units/1/edit')
        ->assertForbidden();
    }
    public function testEdit()
    {
      $product = Product::create(['name' => 'maiz']);
      $unit = $product->units()->create([
        'volumen' => 'arroba',
        'price' =>  10,
        'sponsor' => 1,
        'supsponsor' => .7
      ]);
      Permission::create(['name' => 'products.index']);
      Permission::create(['name' => 'products.edit']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo(Permission::all());
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get("/products/{$product->id}/units/{$unit->id}/edit")->assertSee('Modificar Unidad');
      $this->put("/products/{$product->id}/units/{$unit->id}",['volumen' =>'kilo', 'price' =>  10,
      'sponsor' => 1, 'supsponsor' => .7])->assertRedirect('products/1/units');
      $this->assertDatabaseHas('units', ['volumen' => 'KILO']);
    }
}
